<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        /** @var User $user */
        $user = Auth::user();
        $user->load(['school', 'kvtEmailAccounts']);

        return view('profile.show', compact('user'));
    }

    public function edit()
    {
        /** @var User $user */
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:20',
        ]);

        $oldData = $user->toArray();

        $user->update([
            'nama' => $request->nama,
            'name' => $request->nama,
        ]);

        ActivityLog::log('update_profile', "User {$user->nama} memperbarui profil", $user, $oldData, $user->toArray());

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password lama salah.');
        }

        // Use direct assignment — the User model has 'hashed' cast so it auto-hashes
        $user->password = $request->password;
        $user->save();

        ActivityLog::log('change_password', "User {$user->nama} mengubah password");

        return redirect()->route('profile.show')->with('success', 'Password berhasil diubah.');
    }
}
