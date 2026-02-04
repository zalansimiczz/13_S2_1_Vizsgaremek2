<?php

namespace App\Http\Controllers;

use App\Models\Jarmu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JarmuController extends Controller
{
    //uj jarmu mentese(db-be iras is, validalassal egyutt)
    public function store(Request $request)
    {
        if (!session()->has('ceg_id')) {
            return redirect()->route('partner.login');
        }

        $validated = $request->validate([
    'kategoria' => 'required|string|max:50',
    'marka' => 'required|string|max:50',
    'tipus' => 'required|string|max:50',
    'tengelyszam' => 'required|integer|min:1|max:10',
    'rendszam' => 'required|string|max:20|unique:jarmuvek,rendszam',
    'vin' => 'nullable|string|max:30',
    'euro_besorolas' => 'nullable|string|max:10',
    'ossztomeg_kg' => 'nullable|integer|min:0|max:100000',
    'potkocsi_kepes' => 'required|boolean',
    'aktiv' => 'required|boolean',
]);


$jarmu = new Jarmu();
$jarmu->ceg_id = session('ceg_id');
$jarmu->kategoria = $validated['kategoria'];
$jarmu->marka = $validated['marka'];
$jarmu->tipus = $validated['tipus'];
$jarmu->tengelyszam = $validated['tengelyszam'];
$jarmu->rendszam = $validated['rendszam'];
$jarmu->vin = $validated['vin'];
$jarmu->euro_besorolas = $validated['euro_besorolas'];
$jarmu->ossztomeg_kg = $validated['ossztomeg_kg'];
$jarmu->potkocsi_kepes = $validated['potkocsi_kepes'];
$jarmu->aktiv = $validated['aktiv'];
$jarmu->save();

    return redirect()->route('partner.dashboard', ['tab' => 'trucksContent'])
    ->with('success', 'Jármű sikeresen hozzáadva!');
    }

    //jarmu adatainak modositasa
    public function update(Request $request, $id)
    {
        $cegId = (int) session('ceg_id');
        abort_if($cegId <= 0, 403);

        $data = $request->validate([
    'kategoria' => ['required', 'string', 'max:50'],
    'marka' => ['required', 'string', 'max:50'],
    'tipus' => ['required', 'string', 'max:50'],
    'tengelyszam' => ['required', 'integer', 'min:1', 'max:10'],
    'rendszam' => ['required', 'string', 'max:20', 'unique:jarmuvek,rendszam'],
    'vin' => ['nullable', 'string', 'max:30'],
    'euro_besorolas' => ['nullable', 'string', 'max:10'],
    'ossztomeg_kg' => ['nullable', 'integer', 'min:0', 'max:100000'],
    'potkocsi_kepes' => ['required', 'in:0,1'],
    'aktiv' => ['required', 'in:0,1'],
]);


        DB::table('jarmuvek')
            ->where('id', $id)
            ->where('ceg_id', $cegId)
            ->update($data);

        return redirect()->route('partner.dashboard', ['tab' => 'trucksContent'])
                         ->with('success', 'Jármű adatai frissítve!');
    }

    //aktiv/inaktiv allapot valtas
    public function toggle($id)
    {
        $cegId = (int) session('ceg_id');
        abort_if($cegId <= 0, 403);

        $jarmu = DB::table('jarmuvek')
            ->where('id', $id)
            ->where('ceg_id', $cegId)
            ->first();

        if ($jarmu) {
            DB::table('jarmuvek')
                ->where('id', $id)
                ->update(['aktiv' => !$jarmu->aktiv]);
        }

        return back()->with('success', 'Státusz módosítva!');
    }

    //jarmu torles
    public function destroy($id)
    {
        $cegId = (int) session('ceg_id');
        abort_if($cegId <= 0, 403);

        DB::table('jarmuvek')
            ->where('id', $id)
            ->where('ceg_id', $cegId)
            ->delete();

        return redirect()->route('partner.dashboard', ['tab' => 'trucksContent'])
                         ->with('success', 'Jármű véglegesen törölve!');
    }
}