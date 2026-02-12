@extends('layouts.dashboard')

@section('title', 'Edit User')
@section('page-title', 'Edit User')
@section('page-subtitle', '{{ $user->nama }}')

@section('content')
<div class="max-w-2xl">
    <div class="bg-zinc-950 border border-white/5 rounded-2xl p-8">
        <div class="flex items-center gap-4 mb-6 pb-6 border-b border-white/5">
            <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center text-lg font-bold">{{ strtoupper(substr($user->nama, 0, 1)) }}</div>
            <div>
                <h3 class="font-semibold text-white">{{ $user->nama }}</h3>
                <p class="text-sm text-gray-500 font-mono">{{ $user->kvt_email }}</p>
            </div>
        </div>

        <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-5">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5">Nama Lengkap <span class="text-red-400">*</span></label>
                <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" required>
                @error('nama')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5">Role</label>
                <select name="role" required>
                    <option value="guru" {{ old('role', $user->role) == 'guru' ? 'selected' : '' }}>Guru</option>
                    <option value="siswa" {{ old('role', $user->role) == 'siswa' ? 'selected' : '' }}>Siswa</option>
                </select>
                @error('role')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5">Status</label>
                <select name="status" required>
                    <option value="aktif" {{ old('status', $user->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ old('status', $user->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">NISN</label>
                    <input type="text" name="nisn" value="{{ old('nisn', $user->nisn) }}" placeholder="Untuk siswa">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">NIP</label>
                    <input type="text" name="nip" value="{{ old('nip', $user->nip) }}" placeholder="Untuk guru">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5">Password Baru <span class="text-gray-600">(opsional)</span></label>
                <input type="password" name="password" placeholder="Biarkan kosong jika tidak ingin mengubah">
                @error('password')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="bg-white/5 rounded-xl p-4">
                <p class="text-gray-400 text-xs"><strong class="text-white">Email KVT:</strong> <span class="font-mono text-white">{{ $user->kvt_email }}</span> — email tidak dapat diubah.</p>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-white text-black px-6 py-3 rounded-xl text-sm font-bold hover:bg-gray-200 transition-all">Simpan Perubahan</button>
                <a href="{{ route('users.index') }}" class="border border-white/10 text-gray-400 px-6 py-3 rounded-xl text-sm font-medium hover:border-white/30 transition-all">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
