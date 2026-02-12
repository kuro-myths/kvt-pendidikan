<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): mixed
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        if ($user->status !== 'aktif') {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Akun Anda tidak aktif. Silakan hubungi administrator.');
        }

        if (!in_array($user->role, $roles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
