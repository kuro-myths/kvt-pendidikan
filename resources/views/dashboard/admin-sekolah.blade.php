@extends('layouts.dashboard')

@section('title', 'Dashboard Admin Sekolah')
@section('page-title', 'Dashboard Admin Sekolah')
@section('page-subtitle', $school->nama_sekolah ?? 'Sekolah')

@section('content')
{{-- School Info Card --}}
<div class="bg-zinc-950 border border-white/5 rounded-2xl p-6 mb-6">
    <div class="flex items-start justify-between">
        <div>
            <h3 class="text-xl font-bold text-white mb-1">{{ $school->nama_sekolah }}</h3>
            <p class="text-gray-500 text-sm">NPSN: {{ $school->npsn }} &middot; {{ $school->kota }}, {{ $school->provinsi }}</p>
            <p class="text-gray-600 text-xs mt-1">School Code: <span class="text-white font-mono">{{ $school->school_code }}</span></p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $school->status === 'aktif' ? 'bg-green-500/10 text-green-400' : 'bg-yellow-500/10 text-yellow-400' }}">
                {{ ucfirst($school->status) }}
            </span>
        </div>
    </div>
</div>

{{-- Stats --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-zinc-950 border border-white/5 rounded-2xl p-6">
        <p class="text-gray-500 text-xs uppercase tracking-wider mb-2">Total Guru</p>
        <p class="text-3xl font-bold text-white">{{ $totalGuru }}</p>
    </div>
    <div class="bg-zinc-950 border border-white/5 rounded-2xl p-6">
        <p class="text-gray-500 text-xs uppercase tracking-wider mb-2">Total Siswa</p>
        <p class="text-3xl font-bold text-white">{{ $totalSiswa }}</p>
    </div>
    <div class="bg-zinc-950 border border-white/5 rounded-2xl p-6">
        <p class="text-gray-500 text-xs uppercase tracking-wider mb-2">Total Kelas</p>
        <p class="text-3xl font-bold text-white">{{ $totalKelas }}</p>
    </div>
    <div class="bg-zinc-950 border border-white/5 rounded-2xl p-6">
        <p class="text-gray-500 text-xs uppercase tracking-wider mb-2">Lisensi</p>
        <p class="text-lg font-bold text-white">{{ $license ? ucfirst($license->tipe_lisensi) : 'Tidak Ada' }}</p>
        @if($license)
        <p class="text-xs text-gray-600 mt-1">s.d. {{ $license->berlaku_sampai->format('d M Y') }}</p>
        @endif
    </div>
</div>

<div class="grid md:grid-cols-2 gap-6">
    {{-- Quick Actions --}}
    <div class="bg-zinc-950 border border-white/5 rounded-2xl p-6">
        <h3 class="text-white font-bold mb-4">Aksi Cepat</h3>
        <div class="grid grid-cols-2 gap-3">
            <a href="{{ route('sekolah.users.create') }}" class="bg-white/5 hover:bg-white/10 rounded-xl p-4 text-center transition-colors">
                <svg class="w-6 h-6 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                <p class="text-white text-xs font-medium">Tambah User</p>
            </a>
            <a href="{{ route('sekolah.classes.create') }}" class="bg-white/5 hover:bg-white/10 rounded-xl p-4 text-center transition-colors">
                <svg class="w-6 h-6 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                <p class="text-white text-xs font-medium">Buat Kelas</p>
            </a>
            <a href="{{ route('sekolah.users.index') }}?role=guru" class="bg-white/5 hover:bg-white/10 rounded-xl p-4 text-center transition-colors">
                <svg class="w-6 h-6 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <p class="text-white text-xs font-medium">Daftar Guru</p>
            </a>
            <a href="{{ route('sekolah.users.index') }}?role=siswa" class="bg-white/5 hover:bg-white/10 rounded-xl p-4 text-center transition-colors">
                <svg class="w-6 h-6 mx-auto mb-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                <p class="text-white text-xs font-medium">Daftar Siswa</p>
            </a>
        </div>
    </div>

    {{-- Recent Activity --}}
    <div class="bg-zinc-950 border border-white/5 rounded-2xl p-6">
        <h3 class="text-white font-bold mb-4">Aktivitas Terbaru</h3>
        @forelse($recentLogs as $log)
        <div class="flex items-start gap-3 py-3 border-b border-white/5 last:border-0">
            <div class="w-7 h-7 rounded-full bg-white/5 flex items-center justify-center text-xs font-bold text-gray-400 flex-shrink-0">
                {{ strtoupper(substr($log->user?->nama ?? '?', 0, 1)) }}
            </div>
            <div>
                <p class="text-white text-sm">{{ $log->description }}</p>
                <p class="text-gray-600 text-xs mt-1">{{ $log->created_at->diffForHumans() }}</p>
            </div>
        </div>
        @empty
        <p class="text-gray-600 text-sm py-4">Belum ada aktivitas.</p>
        @endforelse
    </div>
</div>
@endsection
