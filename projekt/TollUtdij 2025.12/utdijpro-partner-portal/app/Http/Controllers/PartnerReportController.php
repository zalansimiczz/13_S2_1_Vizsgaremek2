<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PartnerReportController extends Controller
{
    //partner riportok controller
    public function index()
    {
        //report nezettel visszateres
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
        //report generator request validacio
        $request->validate([
            'report_type' => 'required|string',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
        ]);

        $reportType = $request->report_type;
        $dateFrom = $request->date_from;
        $dateTo = $request->date_to;

        //adatok lekerese kesobb kerul ide
        $results = [];

        //eredmenyek atadasa a report nezettel
        return view('partner.reports.index', [
            'results' => $results,
            'reportType' => $reportType,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
        ]);
    }
}