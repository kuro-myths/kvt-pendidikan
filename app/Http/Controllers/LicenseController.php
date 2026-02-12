<?php

namespace App\Http\Controllers;

use App\Models\KvtLicense;
use App\Models\School;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class LicenseController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = KvtLicense::with('school');

        if (!$user->isAdminKvt()) {
            $query->where('school_id', $user->school_id);
        }

        $licenses = $query->latest()->paginate(15);

        return view('licenses.index', compact('licenses'));
    }

    public function create()
    {
        $schools = School::where('status', 'aktif')->get();
        return view('licenses.create', compact('schools'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'school_id' => 'required|exists:schools,id',
            'tipe_lisensi' => 'required|in:basic,pro,premium',
            'berlaku_mulai' => 'required|date',
            'berlaku_sampai' => 'required|date|after:berlaku_mulai',
        ]);

        $limits = KvtLicense::getLimits($request->tipe_lisensi);

        // Deactivate existing licenses
        KvtLicense::where('school_id', $request->school_id)->where('status', 'aktif')->update(['status' => 'nonaktif']);

        $license = KvtLicense::create([
            'school_id' => $request->school_id,
            'tipe_lisensi' => $request->tipe_lisensi,
            'berlaku_mulai' => $request->berlaku_mulai,
            'berlaku_sampai' => $request->berlaku_sampai,
            'status' => 'aktif',
            ...$limits,
        ]);

        ActivityLog::log('create_license', "Lisensi {$request->tipe_lisensi} dibuat", $license);

        return redirect(role_route('licenses.index'))->with('success', 'Lisensi berhasil dibuat.');
    }

    public function edit(KvtLicense $license)
    {
        $schools = School::where('status', 'aktif')->get();
        return view('licenses.edit', compact('license', 'schools'));
    }

    public function update(Request $request, KvtLicense $license)
    {
        $request->validate([
            'tipe_lisensi' => 'required|in:basic,pro,premium',
            'berlaku_mulai' => 'required|date',
            'berlaku_sampai' => 'required|date|after:berlaku_mulai',
            'status' => 'required|in:aktif,nonaktif,kadaluarsa',
        ]);

        $limits = KvtLicense::getLimits($request->tipe_lisensi);

        $license->update([
            'tipe_lisensi' => $request->tipe_lisensi,
            'berlaku_mulai' => $request->berlaku_mulai,
            'berlaku_sampai' => $request->berlaku_sampai,
            'status' => $request->status,
            ...$limits,
        ]);

        ActivityLog::log('update_license', 'Lisensi diperbarui', $license);

        return redirect(role_route('licenses.index'))->with('success', 'Lisensi berhasil diperbarui.');
    }

    public function destroy(KvtLicense $license)
    {
        ActivityLog::log('delete_license', 'Lisensi dihapus', $license);
        $license->delete();

        return redirect(role_route('licenses.index'))->with('success', 'Lisensi berhasil dihapus.');
    }
}
