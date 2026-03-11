<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ceg;

class PartnerSettingsController extends Controller
{
    public function updateCompany(Request $request)
    {
        $cegId = session('ceg_id');

        if (!$cegId) {
            return back()->withErrors([
                'company' => 'A bejelentkezett felhasználóhoz nincs cég rendelve.'
            ]);
        }

        $ceg = Ceg::find($cegId);

        if (!$ceg) {
            return back()->withErrors([
                'company' => 'A társított cég nem található.'
            ]);
        }

        $validated = $request->validate([
            'nev' => 'nullable|string|max:255',
            'adoszam' => 'nullable|string|max:50',
            'cim' => 'nullable|string|max:255',
        ]);

        $ceg->update([
            'nev' => filled($request->nev) ? $request->nev : $ceg->nev,
            'adoszam' => filled($request->adoszam) ? $request->adoszam : $ceg->adoszam,
            'cim' => filled($request->cim) ? $request->cim : $ceg->cim,
        ]);

        return back()->with('success', 'A cégadatok sikeresen frissítve lettek.');
    }
}