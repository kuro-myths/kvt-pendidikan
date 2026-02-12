<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

// ========================
// PUBLIC ROUTES
// ========================
Route::get('/', function () {
    return view('landing');
})->name('landing');

// ========================
// AUTH ROUTES (Guest only)
// ========================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
    Route::get('/register', [AuthController::class, 'showRegisterSchool'])->name('register');
    Route::post('/register', [AuthController::class, 'registerSchool'])->name('register.process');

    // Password Reset
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

    // Social Login (OAuth)
    Route::get('/auth/{provider}/redirect', [AuthController::class, 'socialRedirect'])->name('social.redirect');
    Route::get('/auth/{provider}/callback', [AuthController::class, 'socialCallback'])->name('social.callback');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ========================
// AUTHENTICATED ROUTES (all roles)
// ========================
Route::middleware(['auth', 'school.access'])->group(function () {
    // Dashboard (auto-redirect by role)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile (all authenticated users)
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

// ========================
// ROLE-BASED ROUTE FILES
// ========================

// Admin KVT — /admin/*
Route::middleware(['auth', 'school.access', 'role:admin_kvt'])
    ->prefix('admin')
    ->name('admin.')
    ->group(base_path('routes/admin.php'));

// Admin Sekolah — /sekolah/*
Route::middleware(['auth', 'school.access', 'role:admin_sekolah'])
    ->prefix('sekolah')
    ->name('sekolah.')
    ->group(base_path('routes/sekolah.php'));

// Guru — /guru/*
Route::middleware(['auth', 'school.access', 'role:guru'])
    ->prefix('guru')
    ->name('guru.')
    ->group(base_path('routes/guru.php'));

// Siswa — /siswa/*
Route::middleware(['auth', 'school.access', 'role:siswa'])
    ->prefix('siswa')
    ->name('siswa.')
    ->group(base_path('routes/siswa.php'));
