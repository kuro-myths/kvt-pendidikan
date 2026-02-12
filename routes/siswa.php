<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KvtScoreController;
use App\Http\Controllers\EduToolController;

// ============================================================
// SISWA ROUTES — prefix: /siswa, name: siswa.
// Middleware: auth, school.access, role:siswa
// ============================================================

// Edu Tools (browse & claim)
Route::prefix('edu-tools')->name('edu-tools.')->controller(EduToolController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/my-tools', 'myTools')->name('my-tools');
    Route::get('/{eduTool}', 'show')->name('show');
    Route::post('/{eduTool}/claim', 'claim')->name('claim');
});

// View own scores
Route::get('/scores', [KvtScoreController::class, 'index'])->name('scores.index');
Route::get('/scores/{score}', [KvtScoreController::class, 'show'])->name('scores.show');
