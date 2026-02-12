<?php

use Illuminate\Support\Facades\Route;
use App\Models\School;
use App\Models\User;
use App\Models\KvtScore;

// ========================
// API v1 — School ID based sync
// ========================
Route::prefix('v1')->group(function () {

    Route::get('/school/{schoolCode}', function ($schoolCode) {
        $school = School::where('school_code', $schoolCode)->with(['license'])->first();
        if (!$school) {
            return response()->json(['error' => 'Sekolah tidak ditemukan'], 404);
        }
        return response()->json($school);
    });

    Route::get('/school/{schoolCode}/students', function ($schoolCode) {
        $school = School::where('school_code', $schoolCode)->first();
        if (!$school) {
            return response()->json(['error' => 'Sekolah tidak ditemukan'], 404);
        }
        $students = User::where('school_id', $school->id)->where('role', 'siswa')->get();
        return response()->json($students);
    });

    Route::get('/school/{schoolCode}/scores', function ($schoolCode) {
        $school = School::where('school_code', $schoolCode)->first();
        if (!$school) {
            return response()->json(['error' => 'Sekolah tidak ditemukan'], 404);
        }
        $scores = KvtScore::where('school_id', $school->id)->with(['student', 'schoolClass'])->get();
        return response()->json($scores);
    });
});
