@extends('layouts.dashboard')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')
@section('page-subtitle', 'Informasi akun Anda')

@section('content')
<div class="max-w-4xl space-y-6">
    {{-- Profile Card --}}
    <div class="bg-zinc-950 border border-white/5 rounded-2xl p-8">
        <div class="flex items-start gap-6">
            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-gray-600 to-gray-800 flex items-center justify-center text-3xl font-black text-white flex-shrink-0">
                {{ strtoupper(substr($user->nama, 0, 1)) }}
            </div>
            <div class="flex-1">
                <h2 class="text-2xl font-bold text-white">{{ $user->nama }}</h2>
                <p class="text-gray-500 mt-1">{{ ucfirst(str_replace('_', ' ', $user->role)) }}</p>
                <div class="flex items-center gap-4 mt-3">
                    <span class="inline-flex items-center gap-1.5 text-sm {{ $user->status === 'aktif' ? 'text-green-400' : 'text-red-400' }}">
                        <span class="w-2 h-2 rounded-full {{ $user->status === 'aktif' ? 'bg-green-400' : 'bg-red-400' }}"></span>
                        {{ ucfirst($user->status) }}
                    </span>
                </div>
            </div>
            <a href="{{ route('profile.edit') }}" class="bg-white/5 hover:bg-white/10 text-white px-4 py-2 rounded-lg text-sm transition-all">
                Edit Profil
            </a>
        </div>
    </div>

    {{-- Info Grid --}}
    <div class="grid md:grid-cols-2 gap-6">
        <div class="bg-zinc-950 border border-white/5 rounded-2xl p-6">
            <h3 class="text-white font-bold text-lg mb-4">Informasi Akun</h3>
            <div class="space-y-4">
                <div>
                    <p class="text-xs text-gray-600 uppercase tracking-wider mb-1">Nama Lengkap</p>
                    <p class="text-white">{{ $user->nama }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-600 uppercase tracking-wider mb-1">Email KVT</p>
                    <p class="text-white font-mono text-sm">{{ $user->kvt_email ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-600 uppercase tracking-wider mb-1">Email</p>
                    <p class="text-white font-mono text-sm">{{ $user->email }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-600 uppercase tracking-wider mb-1">Role</p>
                    <p class="text-white">{{ ucfirst(str_replace('_', ' ', $user->role)) }}</p>
                </div>
                @if($user->nisn)
                <div>
                    <p class="text-xs text-gray-600 uppercase tracking-wider mb-1">NISN</p>
                    <p class="text-white">{{ $user->nisn }}</p>
                </div>
                @endif
                @if($user->nip)
                <div>
                    <p class="text-xs text-gray-600 uppercase tracking-wider mb-1">NIP</p>
                    <p class="text-white">{{ $user->nip }}</p>
                </div>
                @endif
            </div>
        </div>

        <div class="bg-zinc-950 border border-white/5 rounded-2xl p-6">
            <h3 class="text-white font-bold text-lg mb-4">Informasi Sekolah</h3>
            @if($user->school)
            <div class="space-y-4">
                <div>
                    <p class="text-xs text-gray-600 uppercase tracking-wider mb-1">Nama Sekolah</p>
                    <p class="text-white">{{ $user->school->nama_sekolah }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-600 uppercase tracking-wider mb-1">School Code</p>
                    <p class="text-white font-mono">{{ $user->school->school_code }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-600 uppercase tracking-wider mb-1">NPSN</p>
                    <p class="text-white">{{ $user->school->npsn }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-600 uppercase tracking-wider mb-1">Lokasi</p>
                    <p class="text-white">{{ $user->school->kota }}, {{ $user->school->provinsi }}</p>
                </div>
            </div>
            @else
            <p class="text-gray-500">Admin KVT - Tidak terikat sekolah</p>
            @endif
        </div>
    </div>

    {{-- KVT Email Accounts --}}
    @if($user->kvtEmailAccounts && $user->kvtEmailAccounts->count() > 0)
    <div class="bg-zinc-950 border border-white/5 rounded-2xl p-6">
        <h3 class="text-white font-bold text-lg mb-4">Akun Email KVT</h3>
        <div class="space-y-3">
            @foreach($user->kvtEmailAccounts as $account)
            <div class="flex items-center justify-between bg-white/5 rounded-lg px-4 py-3">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-white/10 rounded-full flex items-center justify-center text-xs font-bold">
                        {{ strtoupper(substr($account->display_name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-white font-mono text-sm">{{ $account->kvt_email }}</p>
                        <p class="text-gray-500 text-xs">{{ $account->display_name }}</p>
                    </div>
                </div>
                <span class="text-xs px-2 py-1 rounded-full {{ $account->status === 'aktif' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                    {{ ucfirst($account->status) }}
                </span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Change Password --}}
    <div class="bg-zinc-950 border border-white/5 rounded-2xl p-6">
        <h3 class="text-white font-bold text-lg mb-4">Ubah Password</h3>
        <form action="{{ route('profile.password') }}" method="POST" class="space-y-4 max-w-md">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5">Password Lama</label>
                <input type="password" name="current_password" placeholder="Masukkan password lama" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5">Password Baru</label>
                <input type="password" name="password" placeholder="Minimal 8 karakter" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" placeholder="Ulangi password baru" required>
            </div>
            <button type="submit" class="bg-white text-black px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-200 transition-all">
                Ubah Password
            </button>
        </form>
    </div>
</div>
@endsection
