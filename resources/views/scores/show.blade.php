@extends('layouts.dashboard')

@section('title', 'Detail Nilai KVT')
@section('page-title', 'Detail Nilai KVT')
@section('page-subtitle', 'Informasi lengkap penilaian')

@section('content')
<div class="max-w-3xl">
    <div class="bg-zinc-950 border border-white/5 rounded-2xl p-8">
        {{-- Score Header --}}
        <div class="flex items-start justify-between mb-8">
            <div>
                <h2 class="text-2xl font-bold text-white">{{ $score->kompetensi }}</h2>
                @if($score->sub_kompetensi)
                <p class="text-gray-500 mt-1">{{ $score->sub_kompetensi }}</p>
                @endif
            </div>
            <div class="text-right">
                <div class="text-4xl font-black {{ $score->nilai >= 80 ? 'text-green-400' : ($score->nilai >= 60 ? 'text-yellow-400' : 'text-red-400') }}">
                    {{ number_format($score->nilai, 1) }}
                </div>
                <span class="inline-block mt-1 px-3 py-1 rounded-full text-sm font-bold
                    @switch($score->predikat)
                        @case('A') bg-green-500/20 text-green-400 @break
                        @case('B') bg-blue-500/20 text-blue-400 @break
                        @case('C') bg-yellow-500/20 text-yellow-400 @break
                        @case('D') bg-orange-500/20 text-orange-400 @break
                        @default bg-red-500/20 text-red-400
                    @endswitch
                ">Predikat {{ $score->predikat }}</span>
            </div>
        </div>

        {{-- Details Grid --}}
        <div class="grid md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div>
                    <p class="text-xs text-gray-600 uppercase tracking-wider mb-1">Siswa</p>
                    <p class="text-white">{{ $score->student->nama ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-600 uppercase tracking-wider mb-1">Kelas</p>
                    <p class="text-white">{{ $score->schoolClass->nama_kelas ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-600 uppercase tracking-wider mb-1">Semester</p>
                    <p class="text-white">{{ ucfirst($score->semester) }}</p>
                </div>
            </div>
            <div class="space-y-4">
                <div>
                    <p class="text-xs text-gray-600 uppercase tracking-wider mb-1">Tahun Ajaran</p>
                    <p class="text-white">{{ $score->tahun_ajaran }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-600 uppercase tracking-wider mb-1">Dinilai Oleh</p>
                    <p class="text-white">{{ $score->penilai->nama ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-600 uppercase tracking-wider mb-1">Tanggal Penilaian</p>
                    <p class="text-white">{{ $score->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
        </div>

        @if($score->catatan)
        <div class="mt-6 pt-6 border-t border-white/5">
            <p class="text-xs text-gray-600 uppercase tracking-wider mb-2">Catatan</p>
            <p class="text-gray-300 text-sm leading-relaxed">{{ $score->catatan }}</p>
        </div>
        @endif

        <div class="mt-8 pt-6 border-t border-white/5 flex items-center gap-3">
            <a href="javascript:history.back()" class="text-gray-400 hover:text-white text-sm transition-colors">&larr; Kembali</a>
        </div>
    </div>
</div>
@endsection
