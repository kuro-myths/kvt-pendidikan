@extends('layouts.dashboard')

@section('title', 'Dashboard Admin KVT')
@section('page-title', 'Dashboard Admin KVT')
@section('page-subtitle', 'Pantau seluruh aktivitas platform Universe KVT')

@section('content')
{{-- Stats Cards --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    @php
    $stats = [
        ['label' => 'Total Sekolah', 'value' => $totalSekolah, 'color' => 'from-white/10 to-white/5'],
        ['label' => 'Sekolah Aktif', 'value' => $sekolahAktif, 'color' => 'from-green-500/10 to-green-500/5'],
        ['label' => 'Pending', 'value' => $sekolahPending, 'color' => 'from-yellow-500/10 to-yellow-500/5'],
        ['label' => 'Total User', 'value' => $totalUser, 'color' => 'from-blue-500/10 to-blue-500/5'],
    ];
    @endphp

    @foreach($stats as $stat)
    <div class="bg-gradient-to-br {{ $stat['color'] }} border border-white/5 rounded-2xl p-6">
        <p class="text-gray-500 text-xs uppercase tracking-wider mb-2">{{ $stat['label'] }}</p>
        <p class="text-3xl font-bold text-white">{{ number_format($stat['value']) }}</p>
    </div>
    @endforeach
</div>

<div class="grid md:grid-cols-3 gap-4 mb-8">
    <div class="bg-zinc-950 border border-white/5 rounded-2xl p-6">
        <p class="text-gray-500 text-xs uppercase tracking-wider mb-2">Total Guru</p>
        <p class="text-2xl font-bold text-white">{{ number_format($totalGuru) }}</p>
    </div>
    <div class="bg-zinc-950 border border-white/5 rounded-2xl p-6">
        <p class="text-gray-500 text-xs uppercase tracking-wider mb-2">Total Siswa</p>
        <p class="text-2xl font-bold text-white">{{ number_format($totalSiswa) }}</p>
    </div>
    <div class="bg-zinc-950 border border-white/5 rounded-2xl p-6">
        <p class="text-gray-500 text-xs uppercase tracking-wider mb-2">Lisensi Aktif</p>
        <p class="text-2xl font-bold text-white">{{ number_format($totalLisensi) }}</p>
    </div>
</div>

<div class="grid md:grid-cols-2 gap-6">
    {{-- Pending Schools --}}
    <div class="bg-zinc-950 border border-white/5 rounded-2xl p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-white font-bold">Sekolah Menunggu Persetujuan</h3>
            <a href="{{ route('admin.schools.index') }}?status=pending" class="text-gray-500 hover:text-white text-xs">Lihat Semua &rarr;</a>
        </div>
        @forelse($pendingSchools as $school)
        <div class="flex items-center justify-between py-3 border-b border-white/5 last:border-0">
            <div>
                <p class="text-white text-sm font-medium">{{ $school->nama_sekolah }}</p>
                <p class="text-gray-600 text-xs">NPSN: {{ $school->npsn }} &middot; {{ $school->kota }}</p>
            </div>
            <div class="flex gap-2">
                <form action="{{ route('admin.schools.approve', $school) }}" method="POST">
                    @csrf
                    <button class="bg-green-500/10 text-green-400 px-3 py-1 rounded-lg text-xs hover:bg-green-500/20 transition-colors">Setujui</button>
                </form>
                <form action="{{ route('admin.schools.reject', $school) }}" method="POST">
                    @csrf
                    <button class="bg-red-500/10 text-red-400 px-3 py-1 rounded-lg text-xs hover:bg-red-500/20 transition-colors">Tolak</button>
                </form>
            </div>
        </div>
        @empty
        <p class="text-gray-600 text-sm py-4">Tidak ada sekolah menunggu persetujuan.</p>
        @endforelse
    </div>

    {{-- Recent Activity --}}
    <div class="bg-zinc-950 border border-white/5 rounded-2xl p-6">
        <h3 class="text-white font-bold mb-4">Aktivitas Terbaru</h3>
        @forelse($recentLogs as $log)
        <div class="flex items-start gap-3 py-3 border-b border-white/5 last:border-0">
            <div class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-xs font-bold text-gray-400 flex-shrink-0 mt-0.5">
                {{ strtoupper(substr($log->user?->nama ?? '?', 0, 1)) }}
            </div>
            <div>
                <p class="text-white text-sm">{{ $log->description }}</p>
                <p class="text-gray-600 text-xs mt-1">{{ $log->created_at->diffForHumans() }} &middot; {{ $log->action }}</p>
            </div>
        </div>
        @empty
        <p class="text-gray-600 text-sm py-4">Belum ada aktivitas.</p>
        @endforelse
    </div>
</div>
@endsection
