<?php

namespace App\Http\Controllers\Api;
use OpenApi\Annotations as OA;
use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
/**
 * @OA\Info(title="UtdijPro Partner Portal API", version="1.0.0")
 * @OA\Server(url="http://127.0.0.1:8000", description="Local")
 *
 * @OA\Get(
 *   path="/health",
 *   summary="Health check",
 *   tags={"System"},
 *   @OA\Response(response=200, description="OK")
 * )
 */

class TollController extends Controller
{
    public function calculate(Request $request)
    {
        $data = $request->validate([
            'from' => 'required|string',
            'to' => 'required|string',
            'vehicleType' => 'required|string',
            'waypoints' => 'array',
            'waypoints.*.address' => 'required_with:waypoints|string',
        ]);

        $apiKey = env('API_KEY');
        if (!$apiKey) {
            return response()->json(['error' => 'Hiányzó API_KEY az .env-ben.'], 500);
        }

        // 1) Geokódolás: cím -> lat,lng
        $origin = $this->geocodeHere($data['from'], $apiKey);
        $destination = $this->geocodeHere($data['to'], $apiKey);

        if (!$origin || !$destination) {
            return response()->json(['error' => 'Nem sikerült geokódolni az induló vagy cél címet.'], 422);
        }

        $viaCoords = [];
        $locations = [
            [
                'name' => 'Induló',
                'displayName' => $origin['label'],
                'lat' => $origin['lat'],
                'lng' => $origin['lng'],
            ]
        ];

        if (!empty($data['waypoints'])) {
            foreach ($data['waypoints'] as $idx => $wp) {
                $geo = $this->geocodeHere($wp['address'], $apiKey);
                if ($geo) {
                    $viaCoords[] = $geo['lat'] . ',' . $geo['lng'];
                    $locations[] = [
                        'name' => 'Megálló ' . ($idx + 1),
                        'displayName' => $geo['label'],
                        'lat' => $geo['lat'],
                        'lng' => $geo['lng'],
                    ];
                }
            }
        }

        $locations[] = [
            'name' => 'Cél',
            'displayName' => $destination['label'],
            'lat' => $destination['lat'],
            'lng' => $destination['lng'],
        ];

        // 2) HERE Routing v8 (truck) - origin/destination és via pontok
        $params = [
            'transportMode' => 'truck',
            'origin' => $origin['lat'] . ',' . $origin['lng'],
            'destination' => $destination['lat'] . ',' . $destination['lng'],
            'return' => 'summary,polyline',
            'apikey' => $apiKey,
        ];

        // HERE: többszörös via így megy: via=lat,lng&via=lat,lng...
        // Laravel Http::get-hez külön kezeljük:
        $url = 'https://router.hereapi.com/v8/routes';
        $query = http_build_query($params);
        foreach ($viaCoords as $via) {
            $query .= '&via=' . urlencode($via);
        }

        $resp = Http::timeout(20)->get($url . '?' . $query);

        if (!$resp->successful()) {
            return response()->json([
                'error' => 'HERE Routing API hiba',
                'details' => $resp->json() ?? $resp->body(),
            ], 500);
        }

        $json = $resp->json();

        $route = $json['routes'][0] ?? null;
        $section = $route['sections'][0] ?? null;

        if (!$route || !$section || empty($section['summary'])) {
            return response()->json([
                'error' => 'Nem várt HERE válasz (hiányzó routes/sections/summary).',
                'details' => $json,
            ], 500);
        }

        $lengthMeters = $section['summary']['length'] ?? 0;
        $distanceKm = round($lengthMeters / 1000, 2);

        // 3) Polyline -> routeCoords (Leaflet-hez [lat,lng] tömb)
        $routeCoords = [];
        if (!empty($section['polyline'])) {
            $routeCoords = $this->decodeHereFlexiblePolyline($section['polyline']);
        }

        // 4) Egyszerű díjszámítás (csak demo/placeholder)
        $ratePerKm = $this->ratePerKmByVehicleType($data['vehicleType']); // HUF/km
        $costHUF = (int) round($distanceKm * $ratePerKm);

        return response()->json([
            'costHUF' => $costHUF,
            'currency' => 'HUF',
            'distanceKm' => $distanceKm,
            'routeLink' => null,
            'locations' => $locations,
            'routeCoords' => $routeCoords,
        ]);
    }

    private function geocodeHere(string $query, string $apiKey): ?array
    {
        $resp = Http::timeout(15)->get('https://geocode.search.hereapi.com/v1/geocode', [
            'q' => $query,
            'limit' => 1,
            'apikey' => $apiKey,
        ]);

        if (!$resp->successful()) return null;

        $json = $resp->json();
        $item = $json['items'][0] ?? null;
        if (!$item || empty($item['position'])) return null;

        return [
            'lat' => $item['position']['lat'],
            'lng' => $item['position']['lng'],
            'label' => $item['address']['label'] ?? $query,
        ];
    }

    private function ratePerKmByVehicleType(string $vehicleType): int
    {
        // Placeholder logika: tengelyszám alapján HUF/km
        // Igazi HU útdíj számítás ettől bonyolultabb, de demónak jó.
        return match ($vehicleType) {
            '2AxlesTruck' => 150,
            '3AxlesTruck' => 180,
            '4AxlesTruck' => 210,
            '5AxlesTruck' => 240,
            '6AxlesTruck' => 270,
            '7AxlesTruck' => 300,
            default => 180,
        };
    }

    /**
     * HERE Flexible Polyline dekóder (2D). Vissza: [[lat,lng],...]
     * Minimal implementáció, ami a legtöbb route polylinere elég.
     */
    private function decodeHereFlexiblePolyline(string $encoded): array
    {
        $decoder = new class($encoded) {
            private string $s;
            private int $i = 0;
            private string $table = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_";

            public function __construct(string $s) { $this->s = $s; }

            private function nextValue(): int {
                $result = 0;
                $shift = 0;
                while (true) {
                    $c = $this->s[$this->i++];
                    $v = strpos($this->table, $c);
                    if ($v === false) $v = 0;
                    $result |= ($v & 0x1F) << $shift;
                    if (($v & 0x20) === 0) break;
                    $shift += 5;
                }
                return $result;
            }

            private function zigzag(int $n): int {
                return ($n >> 1) ^ (-(int)($n & 1));
            }

            public function decode(): array {
                // header
                $formatVersion = $this->nextValue();
                if ($formatVersion !== 1 && $formatVersion !== 0) {
                    // ismeretlen verzió, próbáljuk azért
                }
                $header = $this->nextValue();
                $precision = $header & 15;           // 4 bit
                $thirdDim = ($header >> 4) & 7;      // 3 bit
                $thirdDimPrecision = ($header >> 7) & 15;

                $factor = pow(10, $precision);

                $lat = 0;
                $lng = 0;

                $coords = [];
                while ($this->i < strlen($this->s)) {
                    $lat += $this->zigzag($this->nextValue());
                    $lng += $this->zigzag($this->nextValue());

                    if ($thirdDim !== 0) {
                        // third dimension present -> consume it
                        $this->zigzag($this->nextValue());
                    }

                    $coords[] = [$lat / $factor, $lng / $factor];
                }

                return $coords;
            }
        };

        return $decoder->decode();
    }
}
