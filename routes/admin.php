<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\KvtScoreController;
use App\Http\Controllers\ActivityLogController;

// ============================================================
// ADMIN KVT ROUTES — prefix: /admin, name: admin.
// Middleware: auth, school.access, role:admin_kvt
// ============================================================

// Schools Management
Route::controller(SchoolController::class)->prefix('schools')->name('schools.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{school}', 'show')->name('show');
    Route::post('/{school}/approve', 'approve')->name('approve');
    Route::post('/{school}/reject', 'reject')->name('reject');
    Route::post('/{school}/toggle', 'toggleStatus')->name('toggle');
    Route::delete('/{school}', 'destroy')->name('destroy');
});

// Licenses Management (full CRUD)
Route::resource('licenses', LicenseController::class);

// Activity Logs
Route::get('/logs', [ActivityLogController::class, 'index'])->name('logs.index');

// Admin can also manage all users, classes, scores globally
Route::resource('users', UserController::class);
Route::resource('classes', ClassController::class);
Route::resource('scores', KvtScoreController::class);
