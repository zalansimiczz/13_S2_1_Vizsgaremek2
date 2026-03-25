<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PartnerReportController extends Controller
{
    public function index()
    {
        return view('partner.reports.index');
        return view('partner.dashboard', [
        'driverCount' => \App\Models\Sofor::count(),
        'activeDrivers' => \App\Models\Sofor::where('aktiv', 1)->count(),

        'vehicleCount' => \App\Models\Jarmu::count(),
        'activeVehicles' => \App\Models\Jarmu::where('aktiv', 1)->count(),

        'userCount' => \App\Models\User::count(),
    ]);
    }

    public function generate(Request $request)
    {
        $request->validate([
            'report_type' => 'required|string',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
        ]);

        $reportType = $request->report_type;
        $dateFrom = $request->date_from;
        $dateTo = $request->date_to;

        // Itt később jön az adatlekérés
        $results = [];

        return view('partner.reports.index', [
            'results' => $results,
            'reportType' => $reportType,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
        ]);
    }
}