<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PartnerUserController extends Controller
{
    public function store(Request $request)
    {
        if (!session()->has('ceg_id')) {
            return redirect()->route('partner.login');
        }

        $ceg_id = session('ceg_id');

        // Régi PHP logika szerinti mezőnevek
        $full_name  = trim($request->input('full_name'));
        $email      = trim($request->input('email'));
        $password   = $request->input('password');
        $password2  = $request->input('password_confirm');

        // VALIDÁCIÓ (ugyanaz, mint régi rendszerben)
        if ($full_name === '' || $email === '' || $password === '' || $password2 === '') {
            return back()->with('error', 'Hiba: minden mező kitöltése kötelező.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return back()->with('error', 'Hiba: érvénytelen email cím.');
        }

        if ($password !== $password2) {
            return back()->with('error', 'Hiba: a két jelszó nem egyezik.');
        }

        // Email ütközés ellenőrzése
        $exists = DB::table('felhasznalok')
            ->where('email', $email)
            ->first();

        if ($exists) {
            return back()->with('error', 'Hiba: ezzel az email címmel már létezik felhasználó.');
        }

        // Jelszó hash
        $hash = Hash::make($password);

        // Adatbázis beszúrás
        DB::table('felhasznalok')->insert([
            'ceg_id'      => $ceg_id,
            'email'       => $email,
            'jelszo_hash' => $hash,
            'teljes_nev'  => $full_name,
            'aktiv'       => 1,
            'created_at'  => now(),
        ]);

        return redirect()
            ->route('partner.dashboard', ['tab' => 'addUserContent', 'msg' => 'success_user_added'])
            ->with('success', 'Felhasználó sikeresen hozzáadva!');

        
        
    }
    public function toggle($id)
{
    if (!session()->has('ceg_id')) {
        return redirect()->route('partner.login');
    }

    $cegId = (int) session('ceg_id');

    $user = DB::table('felhasznalok')
        ->select('id', 'aktiv')
        ->where('id', $id)
        ->where('ceg_id', $cegId) // 🔒 csak saját cég
        ->first();

    if (!$user) {
        abort(404);
    }

    DB::table('felhasznalok')
        ->where('id', $id)
        ->where('ceg_id', $cegId)
        ->update(['aktiv' => $user->aktiv ? 0 : 1]);

    return redirect()->route('partner.dashboard', ['tab' => 'addUserContent']);
}

}
