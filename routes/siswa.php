<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KvtScoreController;

// ============================================================
// SISWA ROUTES — prefix: /siswa, name: siswa.
// Middleware: auth, school.access, role:siswa
// ============================================================

// View own scores
Route::get('/scores', [KvtScoreController::class, 'index'])->name('scores.index');
Route::get('/scores/{score}', [KvtScoreController::class, 'show'])->name('scores.show');
