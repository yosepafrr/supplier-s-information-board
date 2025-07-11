<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (Auth::check()) {
            $userRole = Auth::user()->role;

            // Jika super_admin, boleh akses semua
            if ($userRole === 'super_admin') {
                return $next($request);
            }

            // Kalau cocok role yang diizinkan
            if (in_array($userRole, $roles)) {
                return $next($request);
            }
        }
        Log::info('CheckRole middleware berjalan untuk user: ' . optional(Auth::user())->email);

        abort(403, 'Unauthorized');
    }
}
