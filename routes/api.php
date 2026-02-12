<?php

use Illuminate\Support\Facades\Route;
use App\Models\School;
use App\Models\User;
use App\Models\KvtScore;

// ========================
// API v1 — Secured with API Key
// ========================
Route::prefix('v1')->middleware('throttle:60,1')->group(function () {

    Route::get('/school/{schoolCode}', function ($schoolCode, \Illuminate\Http\Request $request) {
        // Validate API key
        $apiKey = $request->header('X-API-Key') ?? $request->query('api_key');
        if (!$apiKey || $apiKey !== config('app.api_key', 'kvt-api-secret-2026')) {
            return response()->json(['error' => 'Unauthorized. Invalid API Key.'], 401);
        }

        $school = School::where('school_code', $schoolCode)->with(['license'])->first();
        if (!$school) {
            return response()->json(['error' => 'Sekolah tidak ditemukan'], 404);
        }
        return response()->json($school);
    });

    Route::get('/school/{schoolCode}/students', function ($schoolCode, \Illuminate\Http\Request $request) {
        $apiKey = $request->header('X-API-Key') ?? $request->query('api_key');
        if (!$apiKey || $apiKey !== config('app.api_key', 'kvt-api-secret-2026')) {
            return response()->json(['error' => 'Unauthorized. Invalid API Key.'], 401);
        }

        $school = School::where('school_code', $schoolCode)->first();
        if (!$school) {
            return response()->json(['error' => 'Sekolah tidak ditemukan'], 404);
        }
        // Only return safe fields
        $students = User::where('school_id', $school->id)->where('role', 'siswa')
            ->select('id', 'nama', 'kvt_email', 'nisn', 'status', 'created_at')
            ->get();
        return response()->json($students);
    });

    Route::get('/school/{schoolCode}/scores', function ($schoolCode, \Illuminate\Http\Request $request) {
        $apiKey = $request->header('X-API-Key') ?? $request->query('api_key');
        if (!$apiKey || $apiKey !== config('app.api_key', 'kvt-api-secret-2026')) {
            return response()->json(['error' => 'Unauthorized. Invalid API Key.'], 401);
        }

        $school = School::where('school_code', $schoolCode)->first();
        if (!$school) {
            return response()->json(['error' => 'Sekolah tidak ditemukan'], 404);
        }
        $scores = KvtScore::where('school_id', $school->id)->with(['student:id,nama,kvt_email', 'schoolClass:id,nama_kelas'])->get();
        return response()->json($scores);
    });
});
