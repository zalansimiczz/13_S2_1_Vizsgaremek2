<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sofor;
use App\Models\Felhasznalo;

class PartnerDashboardController extends Controller
{
    public function index(Request $request)
    {

    $cegId = session('ceg_id'); // nálad így van az auth.partner-ben
    // ha nálad máshogy van (pl. session('user_ceg_id')), akkor ezt igazítsd

    $employees = Felhasznalo::where('ceg_id', $cegId)->orderByDesc('created_at')->get();

    $drivers = Sofor::where('ceg_id', $cegId)->orderByDesc('created_at')->get();

    return view('partner.dashboard', compact('employees', 'drivers'));

        // Ha nincs bejelentkezve, megy vissza loginre
        if (! $request->session()->has('user_id')) {
            return redirect()->route('partner.login');
        }

        $userName = $request->session()->get('user_name', 'Partner');
        $role     = 'partner';

        // ✅ Cég ID sessionből
        $cegId = (int) $request->session()->get('ceg_id', 0);

        if ($cegId <= 0) {
            // ha valamiért nincs ceg_id, inkább loginre
            return redirect()->route('partner.login');
        }

        // ✅ Alkalmazottak lekérése (csak a saját cég)
        $employees = DB::table('felhasznalok')
            ->select('id', 'teljes_nev', 'email', 'aktiv', 'role', 'created_at')
            ->where('ceg_id', $cegId)
            ->orderByDesc('created_at')
            ->get();

        return view('partner.dashboard', [
            'userName'  => $userName,
            'role'      => $role,
            'employees' => $employees,
        ]);
    }
}
