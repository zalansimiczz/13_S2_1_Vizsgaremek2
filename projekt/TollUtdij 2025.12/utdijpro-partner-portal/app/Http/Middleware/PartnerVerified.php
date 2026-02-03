<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class PartnerVerified
{
    public function handle(Request $request, Closure $next)
    {
        $userId = session('user_id');

        if (!$userId) {
            return redirect()->route('partner.login');
        }

        $user = User::find($userId);

        // Ha nincs megerősítve az email
        if (!$user || !$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        return $next($request);
    }
}
