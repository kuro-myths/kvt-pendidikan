<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\School;
use App\Models\KvtEmailAccount;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = User::with('school');

        // Scope by school for non-admin_kvt
        if (!$user->isAdminKvt()) {
            $query->where('school_id', $user->school_id);
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('kvt_email', 'like', "%{$search}%")
                    ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(15);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $user = auth()->user();
        $school = $user->isAdminKvt() ? null : School::find($user->school_id);

        return view('users.create', compact('school'));
    }

    public function store(Request $request)
    {
        $authUser = auth()->user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'role' => 'required|in:guru,siswa',
            'nisn' => 'nullable|string|max:20',
            'nip' => 'nullable|string|max:30',
            'password' => 'required|string|min:8',
        ]);

        $schoolId = $authUser->school_id;
        $school = School::find($schoolId);

        if (!$school) {
            return back()->with('error', 'Sekolah tidak ditemukan.');
        }

        // Generate KVT email
        $kvtEmail = User::generateKvtEmail(
            $request->nama,
            $school->school_code,
            $request->role,
            $request->nisn
        );

        // Check uniqueness
        if (User::where('kvt_email', $kvtEmail)->exists()) {
            $kvtEmail = User::generateKvtEmail(
                $request->nama . rand(1, 99),
                $school->school_code,
                $request->role,
                $request->nisn
            );
        }

        $user = User::create([
            'school_id' => $schoolId,
            'nama' => $request->nama,
            'name' => $request->nama,
            'email' => $kvtEmail,
            'kvt_email' => $kvtEmail,
            'nisn' => $request->nisn,
            'nip' => $request->nip,
            'role' => $request->role,
            'status' => 'aktif',
            'password' => $request->password,
        ]);

        // Create KVT Email Account
        KvtEmailAccount::create([
            'user_id' => $user->id,
            'school_id' => $schoolId,
            'kvt_email' => $kvtEmail,
            'display_name' => $request->nama,
            'status' => 'aktif',
        ]);

        ActivityLog::log('create_user', "User {$request->nama} ({$request->role}) ditambahkan dengan email {$kvtEmail}", $user);

        return redirect(role_route('users.index'))->with('success', "User berhasil ditambahkan! Email KVT: {$kvtEmail}");
    }

    public function show(User $user)
    {
        $this->authorizeAccess($user);
        $user->load(['school', 'classes', 'kvtScores', 'kvtEmailAccounts']);
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->authorizeAccess($user);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorizeAccess($user);

        $request->validate([
            'nama' => 'required|string|max:255',
            'role' => 'nullable|in:guru,siswa',
            'status' => 'required|in:aktif,nonaktif,pending',
        ]);

        $oldData = $user->toArray();

        $updateData = [
            'nama' => $request->nama,
            'name' => $request->nama,
            'status' => $request->status,
            'nisn' => $request->nisn,
            'nip' => $request->nip,
        ];

        if ($request->filled('role') && in_array($request->role, ['guru', 'siswa'])) {
            $updateData['role'] = $request->role;
        }

        $user->update($updateData);

        if ($request->filled('password')) {
            // Direct assignment — User model has 'hashed' cast (auto-hashes)
            $user->password = $request->password;
            $user->save();
        }

        ActivityLog::log('update_user', "Data user {$user->nama} diperbarui", $user, $oldData, $user->toArray());

        return redirect(role_route('users.index'))->with('success', 'Data user berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $this->authorizeAccess($user);

        ActivityLog::log('delete_user', "User {$user->nama} dihapus", $user);
        $user->delete();

        return redirect(role_route('users.index'))->with('success', 'User berhasil dihapus.');
    }

    private function authorizeAccess(User $targetUser): void
    {
        $authUser = auth()->user();

        if ($authUser->isAdminKvt()) {
            return;
        }

        if ($authUser->school_id !== $targetUser->school_id) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }
    }
}
