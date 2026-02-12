<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SchoolAccessMiddleware
{
    public function handle(Request $request, Closure $next): mixed
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Admin KVT can access everything
        if ($user->isAdminKvt()) {
            return $next($request);
        }

        // Check if user's school is active
        if ($user->school && $user->school->status !== 'aktif') {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Sekolah Anda belum aktif atau telah dinonaktifkan.');
        }

        return $next($request);
    }
}
