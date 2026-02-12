<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\KvtScore;
use App\Models\KvtLicense;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        return match ($user->role) {
            'admin_kvt' => $this->adminKvtDashboard(),
            'admin_sekolah' => $this->adminSekolahDashboard(),
            'guru' => $this->guruDashboard(),
            'siswa' => $this->siswaDashboard(),
            default => abort(403),
        };
    }

    private function adminKvtDashboard()
    {
        $data = [
            'totalSekolah' => School::count(),
            'sekolahAktif' => School::where('status', 'aktif')->count(),
            'sekolahPending' => School::where('status', 'pending')->count(),
            'totalUser' => User::count(),
            'totalGuru' => User::where('role', 'guru')->count(),
            'totalSiswa' => User::where('role', 'siswa')->count(),
            'totalLisensi' => KvtLicense::where('status', 'aktif')->count(),
            'recentLogs' => ActivityLog::with('user')->latest()->take(10)->get(),
            'recentSchools' => School::latest()->take(5)->get(),
            'pendingSchools' => School::where('status', 'pending')->latest()->take(5)->get(),
        ];

        return view('dashboard.admin-kvt', $data);
    }

    private function adminSekolahDashboard()
    {
        /** @var User $user */
        $user = Auth::user();
        $schoolId = $user->school_id;

        $data = [
            'school' => School::find($schoolId),
            'totalGuru' => User::where('school_id', $schoolId)->where('role', 'guru')->count(),
            'totalSiswa' => User::where('school_id', $schoolId)->where('role', 'siswa')->count(),
            'totalKelas' => SchoolClass::where('school_id', $schoolId)->count(),
            'license' => KvtLicense::where('school_id', $schoolId)->latest()->first(),
            'recentLogs' => ActivityLog::where('school_id', $schoolId)->with('user')->latest()->take(10)->get(),
            'recentStudents' => User::where('school_id', $schoolId)->where('role', 'siswa')->latest()->take(5)->get(),
        ];

        return view('dashboard.admin-sekolah', $data);
    }

    private function guruDashboard()
    {
        /** @var User $user */
        $user = Auth::user();
        $schoolId = $user->school_id;

        $data = [
            'school' => School::find($schoolId),
            'kelasDiajar' => SchoolClass::where('wali_kelas_id', $user->id)->with('students')->get(),
            'totalNilai' => KvtScore::where('dinilai_oleh', $user->id)->count(),
            'recentScores' => KvtScore::where('dinilai_oleh', $user->id)->with('student')->latest()->take(10)->get(),
        ];

        return view('dashboard.guru', $data);
    }

    private function siswaDashboard()
    {
        /** @var User $user */
        $user = Auth::user();

        $data = [
            'school' => School::find($user->school_id),
            'kelas' => $user->classes()->with('waliKelas')->get(),
            'nilaiTerbaru' => KvtScore::where('student_id', $user->id)->latest()->take(10)->get(),
            'rataRata' => KvtScore::where('student_id', $user->id)->avg('nilai'),
        ];

        return view('dashboard.siswa', $data);
    }
}
