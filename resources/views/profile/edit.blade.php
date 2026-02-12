@extends('layouts.dashboard')

@section('title', 'Edit Profil')
@section('page-title', 'Edit Profil')
@section('page-subtitle', 'Perbarui informasi akun Anda')

@section('content')
<div class="max-w-2xl">
    <div class="bg-zinc-950 border border-white/5 rounded-2xl p-8">
        <form action="{{ route('profile.update') }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5">Nama Lengkap</label>
                <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" required>
                @error('nama')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5">Email KVT</label>
                <input type="text" value="{{ $user->kvt_email }}" disabled class="!opacity-50 !cursor-not-allowed">
                <p class="text-gray-600 text-xs mt-1">Email KVT tidak dapat diubah</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5">Role</label>
                <input type="text" value="{{ ucfirst(str_replace('_', ' ', $user->role)) }}" disabled class="!opacity-50 !cursor-not-allowed">
            </div>

            <div class="flex items-center gap-3 pt-4">
                <button type="submit" class="bg-white text-black px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-200 transition-all">
                    Simpan Perubahan
                </button>
                <a href="{{ route('profile.show') }}" class="text-gray-400 hover:text-white text-sm transition-colors">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
