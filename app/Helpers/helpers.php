<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('role_route')) {
    /**
     * Generate a role-prefixed route URL based on the authenticated user's role.
     * Example: role_route('users.index') => route('admin.users.index') for admin_kvt
     */
    function role_route(string $name, mixed $parameters = [], bool $absolute = true): string
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $prefix = match ($user->role ?? 'siswa') {
            'admin_kvt' => 'admin',
            'admin_sekolah' => 'sekolah',
            'guru' => 'guru',
            'siswa' => 'siswa',
        };

        $fullName = "{$prefix}.{$name}";

        // If the role-prefixed route exists, use it; otherwise, try the name as-is
        if (\Illuminate\Support\Facades\Route::has($fullName)) {
            return route($fullName, $parameters, $absolute);
        }

        // Fallback: try route without prefix (shared routes like dashboard, profile, etc.)
        return route($name, $parameters, $absolute);
    }
}

if (!function_exists('role_route_has')) {
    /**
     * Check if a role-prefixed route exists for the authenticated user.
     */
    function role_route_has(string $name): bool
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $prefix = match ($user->role ?? 'siswa') {
            'admin_kvt' => 'admin',
            'admin_sekolah' => 'sekolah',
            'guru' => 'guru',
            'siswa' => 'siswa',
        };

        return \Illuminate\Support\Facades\Route::has("{$prefix}.{$name}");
    }
}
