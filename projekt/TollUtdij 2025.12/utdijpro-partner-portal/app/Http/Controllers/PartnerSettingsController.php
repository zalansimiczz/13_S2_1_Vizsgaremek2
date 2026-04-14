<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ceg;

class PartnerSettingsController extends Controller
{
    //partner cegbeallitasok controller
    public function updateCompany(Request $request)
    {
        //sessionbol olvassa a ceg id-t
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

        //bejarja a bevitt cegadatokat
        $validated = $request->validate([
            'nev' => 'nullable|string|max:255',
            'adoszam' => 'nullable|string|max:50',
            'cim' => 'nullable|string|max:255',
        ]);

        //frissiti a ceg adatait, ha a mezok nem uresek
        $ceg->update([
            'nev' => filled($request->nev) ? $request->nev : $ceg->nev,
            'adoszam' => filled($request->adoszam) ? $request->adoszam : $ceg->adoszam,
            'cim' => filled($request->cim) ? $request->cim : $ceg->cim,
        ]);

        //visszairanyitja a felhasznalot a beallitasokhoz
        return back()->with('success', 'A cégadatok sikeresen frissítve lettek.');
    }
}