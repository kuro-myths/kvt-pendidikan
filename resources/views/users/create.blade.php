@extends('layouts.dashboard')

@section('title', 'Tambah User')
@section('page-title', 'Tambah Guru / Siswa')
@section('page-subtitle', 'Email @kvt.id akan dibuat otomatis')

@section('content')
<div class="max-w-2xl">
    <div class="bg-zinc-950 border border-white/5 rounded-2xl p-8">
        <form action="{{ role_route('users.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5">Nama Lengkap <span class="text-red-400">*</span></label>
                <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Nama lengkap" required>
                @error('nama')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5">Role <span class="text-red-400">*</span></label>
                <select name="role" required>
                    <option value="">Pilih Role</option>
                    <option value="guru" {{ old('role') == 'guru' ? 'selected' : '' }}>Guru</option>
                    <option value="siswa" {{ old('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                </select>
                @error('role')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">NISN (untuk siswa)</label>
                    <input type="text" name="nisn" value="{{ old('nisn') }}" placeholder="Nomor Induk Siswa">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">NIP (untuk guru)</label>
                    <input type="text" name="nip" value="{{ old('nip') }}" placeholder="Nomor Induk Pegawai">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5">Password <span class="text-red-400">*</span></label>
                <input type="password" name="password" placeholder="Minimal 8 karakter" required>
                @error('password')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="bg-white/5 rounded-xl p-4">
                <p class="text-gray-400 text-xs">
                    <strong class="text-white">Info:</strong> Email KVT akan otomatis dibuat berdasarkan nama user dan kode sekolah Anda
                    @if($school)
                    (<span class="text-white font-mono">{{ $school->school_code }}</span>).
                    Contoh: <span class="text-white font-mono">nama.user@{{ $school->school_code }}</span>
                    @endif
                </p>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-white text-black px-6 py-3 rounded-xl text-sm font-bold hover:bg-gray-200 transition-all">Tambah User</button>
                <a href="{{ role_route('users.index') }}" class="border border-white/10 text-gray-400 px-6 py-3 rounded-xl text-sm font-medium hover:border-white/30 transition-all">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
