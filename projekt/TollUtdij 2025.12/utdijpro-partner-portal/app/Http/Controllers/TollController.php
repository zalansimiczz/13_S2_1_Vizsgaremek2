<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TollController extends Controller
{
    public function calculate(Request $request)
    {
        $request->validate([
    'from' => 'required|string|max:255',
    'to' => 'required|string|max:255',
    'vehicleType' => 'required|string',
]);

        return response()->json([
            'costHUF' => 12500,
            'currency' => 'Ft',
            'distanceKm' => 184,
            'routeLink' => null,
            'locations' => [],
            'routeCoords' => [],
        ]);
    }
}