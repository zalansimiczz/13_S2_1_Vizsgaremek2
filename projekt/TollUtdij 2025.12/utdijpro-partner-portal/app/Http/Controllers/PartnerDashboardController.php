<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PartnerDashboardController extends Controller
{
    public function index(Request $request)
    {
        //bejelentkezes ellenorzes session alapjan (MEG NINCS KESZ)
        if (!$request->session()->has('user_id')) {
            return redirect()->route('partner.login');
        }

        //adatok kinyerese az adott sessionbol (MEG NINCS KESZ)
        $userName = $request->session()->get('user_name', 'Partner');
        $cegId    = (int) $request->session()->get('ceg_id', 0);

        if ($cegId <= 0) {
            return redirect()->route('partner.login');
        }

        //alkalmazottak lekerese (felhasznalok tabla a db-ben)
        $employees = DB::table('felhasznalok')
            ->where('ceg_id', $cegId)
            ->orderByDesc('created_at')
            ->get();

        //soforok lekerese (soforok tabla a db-ben)
        $drivers = DB::table('soforok')
            ->where('ceg_id', $cegId)
            ->orderByDesc('created_at')
            ->get();

        //jarmuvek lekerese (jarmuvek tabla a db-ben)
        $trucks = DB::table('jarmuvek')
            ->where('ceg_id', $cegId)
            ->orderByDesc('created_at')
            ->get();


        //adatok atadasa a ui-nak (ez kell a listazashoz)
        return view('partner.dashboard', [
            'userName'  => $userName,
            'employees' => $employees,
            'drivers'   => $drivers,
            'trucks'   => $trucks,
        ]);
    }
}