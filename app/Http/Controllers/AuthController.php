<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\School;
use App\Models\KvtEmailAccount;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
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

        // Rate limiting: max 5 attempts per minute per IP
        $throttleKey = 'login:' . $request->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->with('error', "Terlalu banyak percobaan login. Coba lagi dalam {$seconds} detik.")->withInput();
        }

        $loginField = $request->email;
        $user = User::where('email', $loginField)
            ->orWhere('kvt_email', $loginField)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            RateLimiter::hit($throttleKey, 60);
            return back()->with('error', 'Email atau password salah.')->withInput();
        }

        if ($user->status !== 'aktif') {
            return back()->with('error', 'Akun Anda belum aktif. Silakan tunggu persetujuan admin.')->withInput();
        }

        RateLimiter::clear($throttleKey);

        Auth::login($user, $request->filled('remember'));

        ActivityLog::log('login', "User {$user->nama} berhasil login");

        return redirect()->route('dashboard');
    }

    public function showRegisterSchool()
    {
        if (Auth::check()) {
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

        // Generate KVT email for admin
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

    // ========================
    // PASSWORD RESET
    // ========================

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
        ]);

        $user = User::where('email', $request->email)
            ->orWhere('kvt_email', $request->email)
            ->first();

        if (!$user) {
            return back()->with('error', 'Email tidak ditemukan dalam sistem.');
        }

        // Generate reset token
        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            ['token' => Hash::make($token), 'created_at' => now()]
        );

        // In production, send email. For now, show token directly
        return back()->with('success', "Link reset password telah dikirim. Token: {$token} (Gunakan di halaman reset password)");
    }

    public function showResetPassword(string $token)
    {
        return view('auth.reset-password', compact('token'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'token' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)
            ->orWhere('kvt_email', $request->email)
            ->first();

        if (!$user) {
            return back()->with('error', 'Email tidak ditemukan.');
        }

        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $user->email)
            ->first();

        if (!$resetRecord || !Hash::check($request->token, $resetRecord->token)) {
            return back()->with('error', 'Token reset password tidak valid.');
        }

        // Check token expiry (1 hour)
        if (now()->diffInMinutes($resetRecord->created_at) > 60) {
            return back()->with('error', 'Token reset password telah kadaluarsa.');
        }

        // Update password (User model auto-hashes via 'hashed' cast)
        $user->password = $request->password;
        $user->save();

        // Delete used token
        DB::table('password_reset_tokens')->where('email', $user->email)->delete();

        ActivityLog::log('password_reset', "Password user {$user->nama} direset");

        return redirect()->route('login')->with('success', 'Password berhasil direset. Silakan login dengan password baru.');
    }

    // ========================
    // SOCIAL LOGIN (OAuth)
    // ========================

    public function socialRedirect(string $provider)
    {
        if (!in_array($provider, ['github', 'google'])) {
            return redirect()->route('login')->with('error', 'Provider tidak didukung.');
        }

        return Socialite::driver($provider)->redirect();
    }

    public function socialCallback(string $provider)
    {
        if (!in_array($provider, ['github', 'google'])) {
            return redirect()->route('login')->with('error', 'Provider tidak didukung.');
        }

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal login dengan ' . ucfirst($provider) . '. Silakan coba lagi.');
        }

        // Find existing user by social_id or email
        $user = User::where('social_id', $socialUser->getId())
            ->where('social_type', $provider)
            ->first();

        if (!$user) {
            // Try matching by email
            $user = User::where('email', $socialUser->getEmail())
                ->orWhere('kvt_email', $socialUser->getEmail())
                ->first();

            if ($user) {
                // Link social account to existing user
                $user->update([
                    'social_id' => $socialUser->getId(),
                    'social_type' => $provider,
                    'social_avatar' => $socialUser->getAvatar(),
                ]);
            }
        }

        if (!$user) {
            // No matching user — cannot auto-create for this platform
            return redirect()->route('login')->with('error', 'Akun dengan email ' . $socialUser->getEmail() . ' tidak ditemukan. Silakan daftar melalui sekolah terlebih dahulu, atau hubungi Admin KVT.');
        }

        if ($user->status !== 'aktif') {
            return redirect()->route('login')->with('error', 'Akun Anda belum aktif. Silakan tunggu persetujuan admin.');
        }

        // Update avatar from social if not set
        if (!$user->avatar && $socialUser->getAvatar()) {
            $user->update(['social_avatar' => $socialUser->getAvatar()]);
        }

        Auth::login($user, true);

        ActivityLog::log('social_login', "User {$user->nama} login via " . ucfirst($provider));

        return redirect()->route('dashboard');
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
