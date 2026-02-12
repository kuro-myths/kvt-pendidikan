@extends('layouts.dashboard')

@section('title', 'Dashboard Siswa')
@section('page-title', 'Dashboard Siswa')
@section('page-subtitle', $school->nama_sekolah ?? '')

@section('content')
{{-- Profile Card --}}
<div class="bg-zinc-950 border border-white/5 rounded-2xl p-6 mb-6">
    <div class="flex items-center gap-4">
        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-gray-600 to-gray-800 flex items-center justify-center text-xl font-bold">
            {{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}
        </div>
        <div>
            <h3 class="text-xl font-bold text-white">{{ auth()->user()->nama }}</h3>
            <p class="text-gray-500 text-sm font-mono">{{ auth()->user()->kvt_email ?? auth()->user()->email }}</p>
            @if(auth()->user()->nisn)
            <p class="text-gray-600 text-xs mt-1">NISN: {{ auth()->user()->nisn }}</p>
            @endif
        </div>
    </div>
</div>

{{-- Stats --}}
<div class="grid grid-cols-3 gap-4 mb-8">
    <div class="bg-zinc-950 border border-white/5 rounded-2xl p-6">
        <p class="text-gray-500 text-xs uppercase tracking-wider mb-2">Kelas</p>
        <p class="text-3xl font-bold text-white">{{ $kelas->count() }}</p>
    </div>
    <div class="bg-zinc-950 border border-white/5 rounded-2xl p-6">
        <p class="text-gray-500 text-xs uppercase tracking-wider mb-2">Total Nilai</p>
        <p class="text-3xl font-bold text-white">{{ $nilaiTerbaru->count() }}</p>
    </div>
    <div class="bg-zinc-950 border border-white/5 rounded-2xl p-6">
        <p class="text-gray-500 text-xs uppercase tracking-wider mb-2">Rata-rata</p>
        <p class="text-3xl font-bold text-white">{{ $rataRata ? number_format($rataRata, 1) : '-' }}</p>
    </div>
</div>

<div class="grid md:grid-cols-2 gap-6">
    {{-- Kelas --}}
    <div class="bg-zinc-950 border border-white/5 rounded-2xl p-6">
        <h3 class="text-white font-bold mb-4">Kelas Saya</h3>
        @forelse($kelas as $k)
        <div class="py-3 border-b border-white/5 last:border-0">
            <p class="text-white text-sm font-medium">{{ $k->nama_kelas }}</p>
            <p class="text-gray-600 text-xs">{{ $k->jurusan ?? '-' }} &middot; Wali Kelas: {{ $k->waliKelas?->nama ?? '-' }}</p>
        </div>
        @empty
        <p class="text-gray-600 text-sm py-4">Belum terdaftar di kelas manapun.</p>
        @endforelse
    </div>

    {{-- Nilai Terbaru --}}
    <div class="bg-zinc-950 border border-white/5 rounded-2xl p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-white font-bold">Nilai KVT Terbaru</h3>
            <a href="{{ route('siswa.scores.index') }}" class="text-gray-500 hover:text-white text-xs">Lihat Semua &rarr;</a>
        </div>
        @forelse($nilaiTerbaru as $nilai)
        <div class="flex items-center justify-between py-3 border-b border-white/5 last:border-0">
            <div>
                <p class="text-white text-sm">{{ $nilai->kompetensi }}</p>
                <p class="text-gray-600 text-xs">{{ $nilai->semester }} — {{ $nilai->tahun_ajaran }}</p>
            </div>
            <div class="text-right">
                <p class="text-white font-bold">{{ $nilai->nilai }}</p>
                <span class="text-xs px-2 py-0.5 rounded-full {{ $nilai->predikat === 'A' ? 'bg-green-500/10 text-green-400' : ($nilai->predikat === 'B' ? 'bg-blue-500/10 text-blue-400' : 'bg-gray-500/10 text-gray-400') }}">{{ $nilai->predikat }}</span>
            </div>
        </div>
        @empty
        <p class="text-gray-600 text-sm py-4">Belum ada nilai.</p>
        @endforelse
    </div>
</div>
@endsection
