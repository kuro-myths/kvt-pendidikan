<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\LicenseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\KvtScoreController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\EduToolController;

// ============================================================
// ADMIN KVT ROUTES — prefix: /admin, name: admin.
// Middleware: auth, school.access, role:admin_kvt
// ============================================================

// Edu Tools Management (admin CRUD + approve/reject klaim)
Route::prefix('edu-tools')->name('edu-tools.')->controller(EduToolController::class)->group(function () {
    Route::get('/', 'adminIndex')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/', 'store')->name('store');
    Route::get('/catalog', 'index')->name('catalog');
    Route::get('/my-tools', 'myTools')->name('my-tools');
    Route::get('/{eduTool}', 'show')->name('show');
    Route::get('/{eduTool}/edit', 'edit')->name('edit');
    Route::put('/{eduTool}', 'update')->name('update');
    Route::delete('/{eduTool}', 'destroy')->name('destroy');
    Route::post('/{eduTool}/claim', 'claim')->name('claim');
    Route::post('/claims/{userEduTool}/approve', 'approve')->name('approve');
    Route::post('/claims/{userEduTool}/reject', 'reject')->name('reject');
});

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
