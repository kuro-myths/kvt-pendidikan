<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KvtScoreController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\EduToolController;

// ============================================================
// GURU ROUTES — prefix: /guru, name: guru.
// Middleware: auth, school.access, role:guru
// ============================================================

// Edu Tools (browse & claim)
Route::prefix('edu-tools')->name('edu-tools.')->controller(EduToolController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/my-tools', 'myTools')->name('my-tools');
    Route::get('/{eduTool}', 'show')->name('show');
    Route::post('/{eduTool}/claim', 'claim')->name('claim');
});

// Scores (CRUD for own scores)
Route::resource('scores', KvtScoreController::class);

// Classes (view own classes)
Route::get('/classes', [ClassController::class, 'index'])->name('classes.index');
Route::get('/classes/{class}', [ClassController::class, 'show'])->name('classes.show');
