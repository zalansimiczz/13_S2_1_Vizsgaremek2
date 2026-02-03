<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PartnerAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('partner.login');
        }

        return $next($request);
    }
}
