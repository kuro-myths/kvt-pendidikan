<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KvtScoreController;
use App\Http\Controllers\ClassController;

// ============================================================
// GURU ROUTES — prefix: /guru, name: guru.
// Middleware: auth, school.access, role:guru
// ============================================================

// Scores (CRUD for own scores)
Route::resource('scores', KvtScoreController::class);

// Classes (view own classes)
Route::get('/classes', [ClassController::class, 'index'])->name('classes.index');
Route::get('/classes/{class}', [ClassController::class, 'show'])->name('classes.show');
