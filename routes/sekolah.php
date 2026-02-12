<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\KvtScoreController;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\ProfileController;

// ============================================================
// SEKOLAH ROUTES — prefix: /sekolah, name: sekolah.
// Middleware: auth, school.access, role:admin_sekolah
// ============================================================

// School profile (own school only)
Route::get('/profil', [SchoolController::class, 'showOwn'])->name('profil');

// Users (guru & siswa of own school)
Route::resource('users', UserController::class);

// Classes
Route::resource('classes', ClassController::class);

// Scores
Route::resource('scores', KvtScoreController::class);

// License (view only)
Route::get('/licenses', [LicenseController::class, 'index'])->name('licenses.index');
