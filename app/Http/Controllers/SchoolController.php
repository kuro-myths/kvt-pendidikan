<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\User;
use App\Models\KvtLicense;
use App\Models\KvtEmailAccount;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SchoolController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = School::with(['license', 'adminSekolah']);

        // admin_sekolah can only see own school
        if ($user->isAdminSekolah()) {
            $query->where('id', $user->school_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_sekolah', 'like', "%{$search}%")
                    ->orWhere('npsn', 'like', "%{$search}%")
                    ->orWhere('kota', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $schools = $query->latest()->paginate(15);

        return view('schools.index', compact('schools'));
    }

    public function show(School $school)
    {
        $school->load(['users', 'classes', 'license', 'emailAccounts']);
        return view('schools.show', compact('school'));
    }

    public function showOwn()
    {
        $user = auth()->user();
        $school = School::findOrFail($user->school_id);
        $school->load(['users', 'classes', 'license', 'emailAccounts']);
        return view('schools.show', compact('school'));
    }

    public function approve(School $school)
    {
        $school->update(['status' => 'aktif']);

        // Activate admin sekolah accounts
        User::where('school_id', $school->id)->where('role', 'admin_sekolah')->update(['status' => 'aktif']);

        // Create default license
        KvtLicense::create([
            'school_id' => $school->id,
            'tipe_lisensi' => 'basic',
            'berlaku_mulai' => now(),
            'berlaku_sampai' => now()->addYear(),
            'status' => 'aktif',
            ...KvtLicense::getLimits('basic'),
        ]);

        ActivityLog::log('approve_school', "Sekolah {$school->nama_sekolah} disetujui", $school);

        return back()->with('success', "Sekolah {$school->nama_sekolah} berhasil disetujui dan lisensi Basic telah dibuat.");
    }

    public function reject(School $school)
    {
        $school->update(['status' => 'ditolak']);

        User::where('school_id', $school->id)->update(['status' => 'nonaktif']);

        ActivityLog::log('reject_school', "Sekolah {$school->nama_sekolah} ditolak", $school);

        return back()->with('success', "Sekolah {$school->nama_sekolah} telah ditolak.");
    }

    public function toggleStatus(School $school)
    {
        $newStatus = $school->status === 'aktif' ? 'nonaktif' : 'aktif';
        $school->update(['status' => $newStatus]);

        ActivityLog::log('toggle_school_status', "Status sekolah {$school->nama_sekolah} diubah menjadi {$newStatus}", $school);

        return back()->with('success', "Status sekolah berhasil diubah menjadi {$newStatus}.");
    }

    public function destroy(School $school)
    {
        ActivityLog::log('delete_school', "Sekolah {$school->nama_sekolah} dihapus", $school);
        $school->delete();

        return redirect()->route('admin.schools.index')->with('success', 'Sekolah berhasil dihapus.');
    }
}
