<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PartnerAuthController extends Controller
{
    // LOGIN LAP
    public function showLogin()
    {
        if (session()->has('user_id')) {
            return redirect()->route('partner.dashboard');
        }

        return view('partner.login');
    }

    // LOGIN POST
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Normalizálás
        $email = strtolower(trim($validated['email']));
        $password = (string)$validated['password'];

        $user = DB::table('felhasznalok')
            ->where('email', $email)
            ->first();

        // Egységes, “nem árulkodó” hibaüzenet
        $fail = fn () => back()
            ->withErrors(['login' => 'Hibás email cím vagy jelszó, vagy a felhasználó inaktív.'])
            ->withInput();

        if (!$user) {
            return $fail();
        }

        if ((int)($user->aktiv ?? 0) !== 1) {
            return $fail();
        }

        // Hash mező biztonságos beolvasása
        $hash = $user->jelszo_hash ?? null;

        // Ha nincs hash / nem string → ne 500, hanem sima login fail + log a fejlesztőnek
        if (!is_string($hash) || $hash === '') {
            Log::warning('Login failed: missing/invalid hash', [
                'email' => $email,
                'user_id' => $user->id ?? null,
                'hash_type' => gettype($hash),
            ]);
            return $fail();
        }

        // Ha NEM bcrypt formátum, Hash::check dobhat RuntimeException-t → ezt fogjuk meg
        try {
            if (!Hash::check($password, $hash)) {
                return $fail();
            }
        } catch (\RuntimeException $e) {
            // Itt volt a te 500-asod. Most nem fog elszállni.
            Log::warning('Login failed: hasher runtime exception', [
                'email' => $email,
                'user_id' => $user->id ?? null,
                'hash_prefix' => substr($hash, 0, 10),
                'message' => $e->getMessage(),
            ]);
            return $fail();
        }

        // Sikeres login → session biztonság
        $request->session()->regenerate();

        session([
            'user_id'   => $user->id,
            'ceg_id'    => $user->ceg_id,
            'user_name' => !empty($user->teljes_nev) ? $user->teljes_nev : $user->email,
        ]);

        return redirect()->route('partner.dashboard');
    }

    // LOGOUT
    public function logout(Request $request)
    {
        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('partner.login');
    }

    // REGISZTRÁCIÓS LAP
    public function showRegister()
    {
        if (session()->has('user_id')) {
            return redirect()->route('partner.dashboard');
        }

        return view('partner.register');
    }

    // REGISZTRÁCIÓ POST
    public function register(Request $request)
    {
        $data = $request->validate([
            'ceg_nev'          => ['required', 'string', 'max:255'],
            'adoszam'          => ['nullable', 'string', 'max:50'],
            'cim'              => ['nullable', 'string', 'max:255'],
            'teljes_nev'       => ['required', 'string', 'max:255'],
            'email'            => ['required', 'email', 'max:255'],
            'password'         => ['required', 'string', 'min:8'],
            'password_confirm' => ['required', 'string', 'min:8'],
        ]);

        // password_confirm kompatibilitás
        if ($data['password'] !== $data['password_confirm']) {
            return back()
                ->withErrors(['password' => 'A jelszók nem egyeznek.'])
                ->withInput();
        }

        $email = strtolower(trim($data['email']));

        // email ütközés
        $exists = DB::table('felhasznalok')->where('email', $email)->exists();
        if ($exists) {
            return back()
                ->withErrors(['email' => 'Ezzel az email címmel már létezik felhasználó.'])
                ->withInput();
        }

        try {
            $result = DB::transaction(function () use ($data, $email) {

                // Cég: név alapján keres
                $existingCompany = DB::table('cegek')
                    ->where('nev', $data['ceg_nev'])
                    ->first();

                if ($existingCompany) {
                    $cegId = $existingCompany->id;
                } else {
                    $cegId = DB::table('cegek')->insertGetId([
                        'nev'     => $data['ceg_nev'],
                        'adoszam' => ($data['adoszam'] ?? '') !== '' ? $data['adoszam'] : null,
                        'cim'     => ($data['cim'] ?? '') !== '' ? $data['cim'] : null,
                        'statusz' => 'aktiv',
                    ]);
                }

                $hash = Hash::make($data['password']);

                $userId = DB::table('felhasznalok')->insertGetId([
                    'ceg_id'      => $cegId,
                    'email'       => $email,
                    'jelszo_hash' => $hash,
                    'teljes_nev'  => $data['teljes_nev'],
                    'aktiv'       => 1,
                    'created_at'  => now(),
                ]);

                return [$userId, $cegId];
            });

            [$userId, $cegId] = $result;

            // auto-login + session regenerate
            $request->session()->regenerate();

            session([
                'user_id'   => $userId,
                'ceg_id'    => $cegId,
                'user_name' => $data['teljes_nev'] ?: $email,
            ]);

            return redirect()->route('partner.dashboard');

        } catch (\Throwable $e) {
            Log::error('Registration failed', [
                'email' => $email ?? null,
                'message' => $e->getMessage(),
            ]);

            return back()
                ->withErrors(['general' => 'Váratlan hiba történt a regisztráció során. Próbálja meg később.'])
                ->withInput();
        }
    }
}
