@extends('layouts.dashboard')

@section('title', 'Nilai KVT')
@section('page-title', 'Nilai KVT')
@section('page-subtitle', 'Kelola nilai kompetensi vokasi')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between gap-4">
        <form class="flex gap-3 flex-wrap flex-1" method="GET">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari siswa / kompetensi..." class="flex-1 max-w-xs">
            <select name="semester" onchange="this.form.submit()">
                <option value="">Semua Semester</option>
                <option value="ganjil" {{ request('semester') == 'ganjil' ? 'selected' : '' }}>Semester 1 (Ganjil)</option>
                <option value="genap" {{ request('semester') == 'genap' ? 'selected' : '' }}>Semester 2 (Genap)</option>
            </select>
        </form>
        @if(in_array(auth()->user()->role, ['admin_kvt', 'admin_sekolah', 'guru']))
        <a href="{{ role_route('scores.create') }}" class="bg-white text-black px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-gray-200 transition-all">+ Input Nilai</a>
        @endif
    </div>

    {{-- Table --}}
    <div class="bg-zinc-950 border border-white/5 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead><tr class="text-xs text-gray-500 border-b border-white/5 bg-white/[0.02]">
                    <th class="text-left px-6 py-4">Siswa</th>
                    <th class="text-left px-6 py-4">Kompetensi</th>
                    <th class="text-center px-6 py-4">Nilai</th>
                    <th class="text-center px-6 py-4">Predikat</th>
                    <th class="text-left px-6 py-4">Kelas</th>
                    <th class="text-left px-6 py-4">Semester</th>
                    <th class="text-left px-6 py-4">Penilai</th>
                    <th class="text-right px-6 py-4">Aksi</th>
                </tr></thead>
                <tbody>
                    @forelse($scores as $score)
                    <tr class="border-b border-white/5 hover:bg-white/[0.02] transition-colors">
                        <td class="px-6 py-4">
                            <p class="text-white text-sm font-semibold">{{ $score->student->nama ?? '-' }}</p>
                            <p class="text-gray-500 text-xs font-mono">{{ $score->student->nisn ?? '' }}</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-300">{{ $score->kompetensi }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-white font-mono font-bold text-lg">{{ number_format($score->nilai, 1) }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $predikatColor = match($score->predikat) {
                                    'A' => 'bg-white text-black',
                                    'B' => 'bg-white/20 text-white',
                                    'C' => 'bg-white/10 text-gray-300',
                                    'D' => 'bg-white/5 text-gray-400',
                                    default => 'bg-red-500/10 text-red-400',
                                };
                            @endphp
                            <span class="px-3 py-1 rounded-lg text-xs font-black {{ $predikatColor }}">{{ $score->predikat }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-400">{{ $score->schoolClass->nama_kelas ?? '-' }}</td>
                        <td class="py-3 text-sm text-gray-400">{{ ucfirst($score->semester) }} — {{ $score->tahun_ajaran }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $score->penilai->nama ?? '-' }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ role_route('scores.edit', $score) }}" class="text-gray-500 hover:text-white text-xs px-3 py-1.5 rounded-lg border border-white/10 hover:border-white/30 transition-all">Edit</a>
                                <form action="{{ role_route('scores.destroy', $score) }}" method="POST" onsubmit="return confirm('Hapus nilai ini?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-400 hover:text-red-300 text-xs px-3 py-1.5 rounded-lg border border-red-500/20 hover:border-red-500/40 transition-all">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="px-6 py-12 text-center text-gray-500">Belum ada data nilai.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($scores->hasPages())
    <div class="mt-4">{{ $scores->withQueryString()->links() }}</div>
    @endif
</div>
@endsection
