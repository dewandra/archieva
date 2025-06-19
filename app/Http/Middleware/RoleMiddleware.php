<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles (0: admin, 1: arsip, 2: bidang)
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to access this page.');
        }

        // ...
        $user = Auth::user();

        // Pastikan $user adalah instance dari App\Models\User sebelum melanjutkan
        if (!$user instanceof \App\Models\User) {
            // Jika karena suatu alasan aneh $user bukan model kita,
            // fallback ke halaman login. Ini adalah pengaman.
            return redirect()->route('login');
        }

        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Karena sudah dipastikan tipenya, sekarang aman memanggil getRedirectRoute()
        $redirectRoute = $user->getRedirectRoute();
        return redirect()->route($redirectRoute)->with('error', 'You do not have permission to access this page.');
    }
}
