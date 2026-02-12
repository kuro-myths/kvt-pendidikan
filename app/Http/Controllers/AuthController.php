<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\School;
use App\Models\KvtEmailAccount;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginField = $request->email;
        $user = User::where('email', $loginField)
            ->orWhere('kvt_email', $loginField)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Email atau password salah.')->withInput();
        }

        if ($user->status !== 'aktif') {
            return back()->with('error', 'Akun Anda belum aktif. Silakan tunggu persetujuan admin.')->withInput();
        }

        Auth::login($user, $request->filled('remember'));

        ActivityLog::log('login', "User {$user->nama} berhasil login");

        return redirect()->route('dashboard');
    }

    public function showRegisterSchool()
    {
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.register-school');
    }

    public function registerSchool(Request $request)
    {
        $request->validate([
            'npsn' => 'required|string|unique:schools,npsn|min:8|max:8',
            'nama_sekolah' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
            'jenjang' => 'required|in:SD,SMP,SMA,SMK,MA,Lainnya',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'kepala_sekolah' => 'nullable|string|max:255',
            'nama_admin' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Generate school code kvt.1, kvt.2, etc.
        $schoolCode = School::generateSchoolCode();

        // Create School
        $school = School::create([
            'school_code' => $schoolCode,
            'npsn' => $request->npsn,
            'nama_sekolah' => $request->nama_sekolah,
            'kota' => $request->kota,
            'provinsi' => $request->provinsi,
            'jenjang' => $request->jenjang,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
            'kepala_sekolah' => $request->kepala_sekolah,
            'status' => 'pending',
        ]);

        // Generate KVT email for admin: namaadmin@kvt.X
        $kvtEmail = User::generateKvtEmail($request->nama_admin, $schoolCode, 'admin_sekolah');

        // Create Admin Sekolah user
        $admin = User::create([
            'school_id' => $school->id,
            'nama' => $request->nama_admin,
            'name' => $request->nama_admin,
            'email' => $kvtEmail,
            'kvt_email' => $kvtEmail,
            'role' => 'admin_sekolah',
            'status' => 'pending',
            'password' => $request->password,
        ]);

        // Create KVT Email Account record
        KvtEmailAccount::create([
            'user_id' => $admin->id,
            'school_id' => $school->id,
            'kvt_email' => $kvtEmail,
            'display_name' => $request->nama_admin,
            'status' => 'aktif',
        ]);

        return redirect()->route('login')->with(
            'success',
            "Pendaftaran sekolah berhasil! Akun KVT Anda: {$kvtEmail}. Silakan tunggu persetujuan admin untuk mengaktifkan akun."
        );
    }

    public function logout(Request $request)
    {
        ActivityLog::log('logout', 'User logout');

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing');
    }
}
