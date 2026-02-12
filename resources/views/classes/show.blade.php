@extends('layouts.dashboard')

@section('title', $class->nama_kelas)
@section('page-title', $class->nama_kelas)
@section('page-subtitle', $class->jurusan . ' — ' . $class->tahun_ajaran)

@section('content')
<div class="space-y-6">
    {{-- Header Info --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-zinc-950 border border-white/5 rounded-2xl p-6 text-center">
            <p class="text-3xl font-black text-white">{{ $class->students->count() }}</p>
            <p class="text-xs text-gray-500 mt-1">Siswa</p>
        </div>
        <div class="bg-zinc-950 border border-white/5 rounded-2xl p-6 text-center">
            <p class="text-3xl font-black text-white">{{ $class->tingkat }}</p>
            <p class="text-xs text-gray-500 mt-1">Tingkat</p>
        </div>
        <div class="bg-zinc-950 border border-white/5 rounded-2xl p-6 text-center">
            <p class="text-lg font-bold text-white">{{ $class->waliKelas->nama ?? '-' }}</p>
            <p class="text-xs text-gray-500 mt-1">Wali Kelas</p>
        </div>
        <div class="bg-zinc-950 border border-white/5 rounded-2xl p-6 text-center">
            <p class="text-lg font-bold text-white font-mono">{{ ucfirst($class->semester) }}</p>
            <p class="text-xs text-gray-500 mt-1">{{ $class->tahun_ajaran }}</p>
        </div>
    </div>

    {{-- Actions --}}
    <div class="flex gap-3">
        @if(role_route_has('classes.edit'))<a href="{{ role_route('classes.edit', $class) }}" class="bg-white text-black px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-gray-200 transition-all">Edit Kelas</a>@endif
        <a href="{{ role_route('classes.index') }}" class="border border-white/10 text-gray-400 px-5 py-2.5 rounded-xl text-sm font-medium hover:border-white/30 transition-all">Kembali</a>
    </div>

    {{-- Student List --}}
    <div class="bg-zinc-950 border border-white/5 rounded-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-white/5">
            <h3 class="font-bold text-white">Daftar Siswa</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead><tr class="text-xs text-gray-500 border-b border-white/5 bg-white/[0.02]">
                    <th class="text-left px-6 py-3">#</th>
                    <th class="text-left px-6 py-3">Nama</th>
                    <th class="text-left px-6 py-3">NISN</th>
                    <th class="text-left px-6 py-3">Email KVT</th>
                    <th class="text-center px-6 py-3">Status</th>
                </tr></thead>
                <tbody>
                    @forelse($class->students as $i => $student)
                    <tr class="border-b border-white/5 hover:bg-white/[0.02] transition-colors">
                        <td class="px-6 py-3 text-sm text-gray-500">{{ $i + 1 }}</td>
                        <td class="px-6 py-3">
                            <a href="{{ role_route('users.show', $student) }}" class="text-white text-sm font-semibold hover:underline">{{ $student->nama }}</a>
                        </td>
                        <td class="px-6 py-3 text-sm text-gray-400 font-mono">{{ $student->nisn ?? '-' }}</td>
                        <td class="px-6 py-3 text-sm text-gray-400 font-mono">{{ $student->kvt_email ?? '-' }}</td>
                        <td class="px-6 py-3 text-center">
                            <span class="px-2.5 py-1 rounded-lg text-xs font-bold {{ $student->status == 'aktif' ? 'bg-emerald-500/10 text-emerald-400' : 'bg-red-500/10 text-red-400' }}">
                                {{ ucfirst($student->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500 text-sm">Belum ada siswa di kelas ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
