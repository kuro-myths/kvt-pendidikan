<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SchoolAccessMiddleware
{
    public function handle(Request $request, Closure $next): mixed
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Admin KVT can access everything
        if ($user->isAdminKvt()) {
            return $next($request);
        }

        // Check if user's school is active
        if ($user->school && $user->school->status !== 'aktif') {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Sekolah Anda belum aktif atau telah dinonaktifkan.');
        }

        return $next($request);
    }
}
