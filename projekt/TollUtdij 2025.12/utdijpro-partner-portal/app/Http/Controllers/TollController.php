<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class TollController extends Controller
{
    public function calculate(Request $request)
    {
        $validated = $request->validate([
            'from' => ['required', 'string', 'max:255'],
            'to' => ['required', 'string', 'max:255'],
            'vehicleType' => ['required', 'string', 'max:100'],
            'waypoints' => ['nullable', 'array'],
            'waypoints.*.address' => ['nullable', 'string', 'max:255'],
        ]);

        $from = trim($validated['from']);
        $to = trim($validated['to']);
        $vehicleType = $validated['vehicleType'];
        $waypoints = collect($validated['waypoints'] ?? [])
            ->pluck('address')
            ->filter(fn ($v) => filled($v))
            ->map(fn ($v) => trim($v))
            ->values()
            ->all();

        try {
            $locations = [];
            $routePoints = [];

            $start = $this->geocodeAddress($from);
            $locations[] = [
                'name' => 'Indulás',
                'displayName' => $from,
                'lat' => $start['lat'],
                'lng' => $start['lng'],
            ];
            $routePoints[] = [$start['lng'], $start['lat']];

            foreach ($waypoints as $index => $waypoint) {
                $geo = $this->geocodeAddress($waypoint);
                $locations[] = [
                    'name' => 'Megálló ' . ($index + 1),
                    'displayName' => $waypoint,
                    'lat' => $geo['lat'],
                    'lng' => $geo['lng'],
                ];
                $routePoints[] = [$geo['lng'], $geo['lat']];
            }

            $end = $this->geocodeAddress($to);
            $locations[] = [
                'name' => 'Érkezés',
                'displayName' => $to,
                'lat' => $end['lat'],
                'lng' => $end['lng'],
            ];
            $routePoints[] = [$end['lng'], $end['lat']];

            $route = $this->getRoute($routePoints);

            $distanceKm = round(($route['distance_m'] / 1000), 1);
            $costHUF = $this->estimateToll($distanceKm, $vehicleType);

            $routeCoords = collect($route['coordinates'])
                ->map(function ($coord) {
                    return [$coord[1], $coord[0]]; // [lat, lng] Leaflethez
                })
                ->values()
                ->all();

            return response()->json([
                'costHUF' => $costHUF,
                'currency' => 'Ft',
                'distanceKm' => $distanceKm,
                'routeLink' => $this->buildGoogleMapsLink($from, $to, $waypoints),
                'locations' => $locations,
                'routeCoords' => $routeCoords,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'A kalkuláció sikertelen.',
                'details' => [
                    'message' => $e->getMessage(),
                ],
            ], 422);
        }
    }

    private function geocodeAddress(string $address): array
{
    $response = Http::timeout(20)
        ->withHeaders([
            'User-Agent' => config('app.name', 'Laravel') . '/1.0',
            'Accept-Language' => 'hu',
        ])
        ->withOptions([
            'verify' => false, // ideiglenes fix lokál fejlesztéshez
        ])
        ->get('https://nominatim.openstreetmap.org/search', [
            'q' => $address,
            'format' => 'jsonv2',
            'limit' => 1,
            'countrycodes' => 'hu',
        ]);

    if (!$response->ok()) {
        throw new \Exception('A geokódoló szolgáltatás nem elérhető.');
    }

    $data = $response->json();

    if (empty($data) || !isset($data[0]['lat'], $data[0]['lon'])) {
        throw new \Exception("A cím nem található: {$address}");
    }

    return [
        'lat' => (float) $data[0]['lat'],
        'lng' => (float) $data[0]['lon'],
    ];
}

    private function getRoute(array $points): array
{
    if (count($points) < 2) {
        throw new \Exception('Legalább két pont szükséges az útvonalhoz.');
    }

    $coordinates = collect($points)
        ->map(fn ($p) => $p[0] . ',' . $p[1])
        ->implode(';');

    $response = Http::timeout(30)
        ->withOptions([
            'verify' => false, // ideiglenes fix lokál fejlesztéshez
        ])
        ->get("https://router.project-osrm.org/route/v1/driving/{$coordinates}", [
            'overview' => 'full',
            'geometries' => 'geojson',
            'steps' => 'false',
        ]);

    if (!$response->ok()) {
        throw new \Exception('Az útvonaltervező szolgáltatás nem elérhető.');
    }

    $data = $response->json();

    if (
        !isset($data['routes'][0]['distance']) ||
        !isset($data['routes'][0]['geometry']['coordinates'])
    ) {
        throw new \Exception('Nem sikerült útvonalat számolni.');
    }

    return [
        'distance_m' => (float) $data['routes'][0]['distance'],
        'coordinates' => $data['routes'][0]['geometry']['coordinates'],
    ];
}

    private function estimateToll(float $distanceKm, string $vehicleType): int
    {
        $rates = [
            '2AxlesTruck' => 85,
            '3AxlesTruck' => 110,
            '4AxlesTruck' => 135,
            '5AxlesTruck' => 160,
            '6AxlesTruck' => 185,
            '7AxlesTruck' => 210,
        ];

        $ratePerKm = $rates[$vehicleType] ?? 120;

        return (int) round($distanceKm * $ratePerKm);
    }

    private function buildGoogleMapsLink(string $from, string $to, array $waypoints = []): ?string
    {
        $params = [
            'api' => '1',
            'origin' => $from,
            'destination' => $to,
            'travelmode' => 'driving',
        ];

        if (!empty($waypoints)) {
            $params['waypoints'] = implode('|', $waypoints);
        }

        return 'https://www.google.com/maps/dir/?' . http_build_query($params);
    }
}