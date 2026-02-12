<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\KvtScoreController;
use App\Http\Controllers\LicenseController;

// ========================
// PUBLIC ROUTES
// ========================
Route::get('/', function () {
    return view('landing');
})->name('landing');

// ========================
// AUTH ROUTES
// ========================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
    Route::get('/register', [AuthController::class, 'showRegisterSchool'])->name('register');
    Route::post('/register', [AuthController::class, 'registerSchool'])->name('register.process');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ========================
// AUTHENTICATED ROUTES
// ========================
Route::middleware(['auth', 'school.access'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ========================
    // ADMIN KVT ROUTES
    // ========================
    Route::middleware(['role:admin_kvt'])->prefix('admin')->name('admin.')->group(function () {
        Route::post('/schools/{school}/approve', [SchoolController::class, 'approve'])->name('schools.approve');
        Route::post('/schools/{school}/reject', [SchoolController::class, 'reject'])->name('schools.reject');
        Route::post('/schools/{school}/toggle', [SchoolController::class, 'toggleStatus'])->name('schools.toggle');
        Route::delete('/schools/{school}', [SchoolController::class, 'destroy'])->name('schools.destroy');
    });

    // Licenses — full CRUD for admin_kvt, index for admin_sekolah
    Route::middleware(['role:admin_kvt'])->group(function () {
        Route::resource('licenses', LicenseController::class)->except(['index']);
    });

    // ========================
    // SCHOOL MANAGEMENT ROUTES (admin_kvt + admin_sekolah)
    // ========================
    Route::middleware(['role:admin_kvt,admin_sekolah'])->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('classes', ClassController::class);
    });

    // ========================
    // SCHOOLS (accessible)
    // ========================
    Route::middleware(['role:admin_kvt,admin_sekolah'])->group(function () {
        Route::get('/schools', [SchoolController::class, 'index'])->name('schools.index');
        Route::get('/schools/{school}', [SchoolController::class, 'show'])->name('schools.show');
    });

    // ========================
    // KVT SCORES (guru + admin)
    // ========================
    Route::middleware(['role:admin_kvt,admin_sekolah,guru'])->group(function () {
        Route::resource('scores', KvtScoreController::class);
    });

    // ========================
    // SISWA: VIEW SCORES
    // ========================
    Route::middleware(['role:siswa'])->group(function () {
        Route::get('/my-scores', [KvtScoreController::class, 'index'])->name('my-scores');
    });

    // ========================
    // LICENSES (view for admin_sekolah too)
    // ========================
    Route::middleware(['role:admin_kvt,admin_sekolah'])->group(function () {
        Route::get('/licenses', [LicenseController::class, 'index'])->name('licenses.index');
    });
});
