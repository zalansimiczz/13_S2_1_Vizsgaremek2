<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PartnerDashboardController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ellenőrizzük a bejelentkezést a session alapján
        if (!$request->session()->has('user_id')) {
            return redirect()->route('partner.login');
        }

        // 2. Adatok kinyerése a sessionből
        $userName = $request->session()->get('user_name', 'Partner');
        $cegId    = (int) $request->session()->get('ceg_id', 0);

        if ($cegId <= 0) {
            return redirect()->route('partner.login');
        }

        // 3. Alkalmazottak lekérése (felhasznalok tábla)
        $employees = DB::table('felhasznalok')
            ->where('ceg_id', $cegId)
            ->orderByDesc('created_at')
            ->get();

        // 4. Sofőrök lekérése (soforok tábla)
        $drivers = DB::table('soforok')
            ->where('ceg_id', $cegId)
            ->orderByDesc('created_at')
            ->get();

        // 5. Adatok átadása a view-nak
        return view('partner.dashboard', [
            'userName'  => $userName,
            'employees' => $employees,
            'drivers'   => $drivers, // <--- Ez kell a sofőrök listázásához
        ]);
    }
}