@extends('layouts.dashboard')

@section('title', 'Manajemen Kelas')
@section('page-title', 'Kelas')
@section('page-subtitle', 'Kelola kelas dan siswa')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between gap-4">
        <form class="flex gap-3 flex-1" method="GET">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kelas..." class="flex-1 max-w-xs">
            <select name="tingkat" onchange="this.form.submit()">
                <option value="">Semua Tingkat</option>
                @for($i = 10; $i <= 12; $i++)
                <option value="{{ $i }}" {{ request('tingkat') == $i ? 'selected' : '' }}>Tingkat {{ $i }}</option>
                @endfor
            </select>
        </form>
        <a href="{{ role_route('classes.create') }}" class="bg-white text-black px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-gray-200 transition-all">+ Tambah Kelas</a>
    </div>

    {{-- Table --}}
    <div class="bg-zinc-950 border border-white/5 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead><tr class="text-xs text-gray-500 border-b border-white/5 bg-white/[0.02]">
                    <th class="text-left px-6 py-4">Kelas</th>
                    <th class="text-left px-6 py-4">Jurusan</th>
                    <th class="text-center px-6 py-4">Tingkat</th>
                    <th class="text-left px-6 py-4">Wali Kelas</th>
                    <th class="text-center px-6 py-4">Siswa</th>
                    <th class="text-left px-6 py-4">Tahun Ajaran</th>
                    <th class="text-right px-6 py-4">Aksi</th>
                </tr></thead>
                <tbody>
                    @forelse($classes as $class)
                    <tr class="border-b border-white/5 hover:bg-white/[0.02] transition-colors">
                        <td class="px-6 py-4">
                            <a href="{{ role_route('classes.show', $class) }}" class="text-white font-semibold text-sm hover:underline">{{ $class->nama_kelas }}</a>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-400">{{ $class->jurusan ?? '-' }}</td>
                        <td class="px-6 py-4 text-center"><span class="bg-white/10 text-white px-2.5 py-1 rounded-lg text-xs font-bold">{{ $class->tingkat }}</span></td>
                        <td class="px-6 py-4 text-sm text-gray-400">{{ $class->waliKelas->nama ?? '-' }}</td>
                        <td class="px-6 py-4 text-center text-sm text-white font-mono">{{ $class->students_count ?? $class->students->count() }}</td>
                        <td class="px-6 py-4 text-sm text-gray-400">{{ $class->tahun_ajaran }} / {{ ucfirst($class->semester) }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ role_route('classes.edit', $class) }}" class="text-gray-500 hover:text-white text-xs px-3 py-1.5 rounded-lg border border-white/10 hover:border-white/30 transition-all">Edit</a>
                                <form action="{{ role_route('classes.destroy', $class) }}" method="POST" onsubmit="return confirm('Hapus kelas ini?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-400 hover:text-red-300 text-xs px-3 py-1.5 rounded-lg border border-red-500/20 hover:border-red-500/40 transition-all">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-6 py-12 text-center text-gray-500">Belum ada kelas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($classes->hasPages())
    <div class="mt-4">{{ $classes->withQueryString()->links() }}</div>
    @endif
</div>
@endsection
