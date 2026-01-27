<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SoforController extends Controller
{
    public function store(Request $request)
    {
       $cegId = session('ceg_id');

    $data = $request->validate([
        'aktiv' => 'required|boolean',
        'nev' => 'required|string|max:255',
        'szemelyi_azonosito' => 'nullable|string|max:50',
        'szuletesi_datum' => 'nullable|date',
        'telefonszam' => 'required|string|max:50',
        'cim' => 'nullable|string|max:255',
        'adoszam' => 'nullable|string|max:50',
    ]);

    $data['ceg_id'] = $cegId;

    Sofor::create($data);

    return redirect()
        ->route('partner.dashboard', ['tab' => 'driversContent'])
        ->with('success', 'Sofőr mentve!');
    }

    public function update(Request $request, $id)
    {
        $cegId = (int) session('ceg_id');
        abort_if($cegId <= 0, 403);

        $data = $request->validate([
            'nev' => ['required','string','max:255'],
            'szemelyi_azonosito' => ['nullable','string','max:100'],
            'szuletesi_datum' => ['nullable','date'],
            'telefonszam' => ['required','string','max:50'],
            'cim' => ['nullable','string','max:255'],
            'adoszam' => ['nullable','string','max:50'],
            'aktiv' => ['required','in:0,1'],
        ]);

        DB::table('soforok')
            ->where('id', $id)
            ->where('ceg_id', $cegId)   // csak saját cég!
            ->update($data);

        return back()->with('success', 'Sofőr frissítve.');
        return redirect()->route('partner.dashboard', ['tab' => 'driversContent']);
    }

    public function destroy(Request $request, $id)
    {
        $cegId = (int) session('ceg_id');
        abort_if($cegId <= 0, 403);

        DB::table('soforok')
            ->where('id', $id)
            ->where('ceg_id', $cegId)
            ->delete();

        return back()->with('success', 'Sofőr törölve.');
        return redirect()->route('partner.dashboard', ['tab' => 'driversContent']);
    }
}
