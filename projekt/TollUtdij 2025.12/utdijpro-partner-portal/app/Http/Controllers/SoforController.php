<?php

namespace App\Http\Controllers;

use App\Models\Sofor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SoforController extends Controller
{
    //uj sofor mentese(db-be iras is, validalassal egyutt)
    public function store(Request $request)
    {
        if (!session()->has('ceg_id')) {
            return redirect()->route('partner.login');
        }

        $validated = $request->validate([
            'aktiv' => 'required|boolean',
            'nev' => 'required|string|max:255',
            'szemelyi_azonosito' => 'nullable|string|max:50',
            'szuletesi_datum' => 'nullable|date',
            'telefonszam' => 'required|string|max:50',
            'cim' => 'nullable|string|max:255',
            'adoszam' => 'nullable|string|max:50',
        ]);

        $sofor = new Sofor();
        $sofor->ceg_id = session('ceg_id');
        $sofor->aktiv = $validated['aktiv'];
        $sofor->nev = $validated['nev'];
        $sofor->szemelyi_azonosito = $validated['szemelyi_azonosito'];
        $sofor->szuletesi_datum = $validated['szuletesi_datum'];
        $sofor->telefonszam = $validated['telefonszam'];
        $sofor->cim = $validated['cim'];
        $sofor->adoszam = $validated['adoszam'];
        $sofor->save();

        return redirect()->route('partner.dashboard', ['tab' => 'driversContent'])
                         ->with('success', 'Sofőr sikeresen hozzáadva!');
    }

    //sofor adatainak modositasa
    public function update(Request $request, $id)
    {
        $cegId = (int) session('ceg_id');
        abort_if($cegId <= 0, 403);

        $data = $request->validate([
            'nev' => ['required', 'string', 'max:255'],
            'szemelyi_azonosito' => ['nullable', 'string', 'max:50'],
            'szuletesi_datum' => ['nullable', 'date'],
            'telefonszam' => ['required', 'string', 'max:50'],
            'cim' => ['nullable', 'string', 'max:255'],
            'adoszam' => ['nullable', 'string', 'max:50'],
            'aktiv' => ['required', 'in:0,1'],
        ]);

        DB::table('soforok')
            ->where('id', $id)
            ->where('ceg_id', $cegId)
            ->update($data);

        return redirect()->route('partner.dashboard', ['tab' => 'driversContent'])
                         ->with('success', 'Sofőr adatai frissítve!');
    }

    //aktiv/inaktiv allapot valtas
    public function toggle($id)
    {
        $cegId = (int) session('ceg_id');
        abort_if($cegId <= 0, 403);

        $sofor = DB::table('soforok')
            ->where('id', $id)
            ->where('ceg_id', $cegId)
            ->first();

        if ($sofor) {
            DB::table('soforok')
                ->where('id', $id)
                ->update(['aktiv' => !$sofor->aktiv]);
        }

        return back()->with('success', 'Státusz módosítva!');
    }

    //sofor torles
    public function destroy($id)
    {
        $cegId = (int) session('ceg_id');
        abort_if($cegId <= 0, 403);

        DB::table('soforok')
            ->where('id', $id)
            ->where('ceg_id', $cegId)
            ->delete();

        return redirect()->route('partner.dashboard', ['tab' => 'driversContent'])
                         ->with('success', 'Sofőr véglegesen törölve!');
    }
}