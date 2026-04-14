<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PartnerAuth
{
    //middleware a partner login ellenorzeshez
    public function handle(Request $request, Closure $next)
    {
        //ha nincs user_id a sessionben, atiranyitja a felhasznalot
        if (!session()->has('user_id')) {
            return redirect()->route('partner.login');
        }

        //ha van user_id, tovabbengedjuk a kerezest
        return $next($request);
    }
}
