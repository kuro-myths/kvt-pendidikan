@extends('layouts.dashboard')

@section('title', 'Dashboard Guru')
@section('page-title', 'Dashboard Guru')
@section('page-subtitle', $school->nama_sekolah ?? '')

@section('content')
<div class="grid md:grid-cols-3 gap-4 mb-8">
    <div class="bg-zinc-950 border border-white/5 rounded-2xl p-6">
        <p class="text-gray-500 text-xs uppercase tracking-wider mb-2">Kelas Diampu</p>
        <p class="text-3xl font-bold text-white">{{ $kelasDiajar->count() }}</p>
    </div>
    <div class="bg-zinc-950 border border-white/5 rounded-2xl p-6">
        <p class="text-gray-500 text-xs uppercase tracking-wider mb-2">Total Siswa</p>
        <p class="text-3xl font-bold text-white">{{ $kelasDiajar->sum(fn($k) => $k->students->count()) }}</p>
    </div>
    <div class="bg-zinc-950 border border-white/5 rounded-2xl p-6">
        <p class="text-gray-500 text-xs uppercase tracking-wider mb-2">Nilai Diinput</p>
        <p class="text-3xl font-bold text-white">{{ $totalNilai }}</p>
    </div>
</div>

<div class="grid md:grid-cols-2 gap-6">
    {{-- Kelas --}}
    <div class="bg-zinc-950 border border-white/5 rounded-2xl p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-white font-bold">Kelas Saya</h3>
            <a href="{{ route('guru.scores.create') }}" class="bg-white text-black px-4 py-2 rounded-lg text-xs font-semibold hover:bg-gray-200 transition-all">+ Tambah Nilai</a>
        </div>
        @forelse($kelasDiajar as $kelas)
        <div class="py-3 border-b border-white/5 last:border-0">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-white text-sm font-medium">{{ $kelas->nama_kelas }}</p>
                    <p class="text-gray-600 text-xs">{{ $kelas->jurusan ?? '-' }} &middot; {{ $kelas->tahun_ajaran }}</p>
                </div>
                <span class="text-gray-500 text-xs">{{ $kelas->students->count() }} siswa</span>
            </div>
        </div>
        @empty
        <p class="text-gray-600 text-sm py-4">Belum ada kelas yang diampu.</p>
        @endforelse
    </div>

    {{-- Recent Scores --}}
    <div class="bg-zinc-950 border border-white/5 rounded-2xl p-6">
        <h3 class="text-white font-bold mb-4">Nilai Terbaru</h3>
        @forelse($recentScores as $score)
        <div class="flex items-center justify-between py-3 border-b border-white/5 last:border-0">
            <div>
                <p class="text-white text-sm">{{ $score->student?->nama ?? '-' }}</p>
                <p class="text-gray-600 text-xs">{{ $score->kompetensi }}</p>
            </div>
            <div class="text-right">
                <p class="text-white font-bold">{{ $score->nilai }}</p>
                <span class="text-xs px-2 py-0.5 rounded-full {{ $score->predikat === 'A' ? 'bg-green-500/10 text-green-400' : ($score->predikat === 'B' ? 'bg-blue-500/10 text-blue-400' : 'bg-gray-500/10 text-gray-400') }}">{{ $score->predikat }}</span>
            </div>
        </div>
        @empty
        <p class="text-gray-600 text-sm py-4">Belum ada nilai diinput.</p>
        @endforelse
    </div>
</div>
@endsection
