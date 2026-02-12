@extends('layouts.dashboard')

@section('title', 'Kelola Sekolah')
@section('page-title', 'Kelola Sekolah')
@section('page-subtitle', 'Daftar semua sekolah terdaftar di Universe KVT')

@section('content')
{{-- Filters --}}
<div class="bg-zinc-950 border border-white/5 rounded-2xl p-4 mb-6">
    <form action="" method="GET" class="flex flex-wrap gap-3 items-end">
        <div class="flex-1 min-w-[200px]">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama sekolah, NPSN, atau kota...">
        </div>
        <div class="w-40">
            <select name="status">
                <option value="">Semua Status</option>
                @foreach(['pending', 'aktif', 'nonaktif', 'ditolak'] as $s)
                <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-white text-black px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-200 transition-all">Filter</button>
    </form>
</div>

{{-- Table --}}
<div class="bg-zinc-950 border border-white/5 rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-white/5">
                    <th class="text-left px-6 py-4 text-gray-500 font-medium text-xs uppercase">Sekolah</th>
                    <th class="text-left px-6 py-4 text-gray-500 font-medium text-xs uppercase">NPSN</th>
                    <th class="text-left px-6 py-4 text-gray-500 font-medium text-xs uppercase">Kode</th>
                    <th class="text-left px-6 py-4 text-gray-500 font-medium text-xs uppercase">Lokasi</th>
                    <th class="text-left px-6 py-4 text-gray-500 font-medium text-xs uppercase">Status</th>
                    <th class="text-left px-6 py-4 text-gray-500 font-medium text-xs uppercase">Lisensi</th>
                    <th class="text-right px-6 py-4 text-gray-500 font-medium text-xs uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($schools as $school)
                <tr class="border-b border-white/5 hover:bg-white/[0.02] transition-colors">
                    <td class="px-6 py-4">
                        <a href="{{ route('schools.show', $school) }}" class="text-white font-medium hover:underline">{{ $school->nama_sekolah }}</a>
                        <p class="text-gray-600 text-xs">{{ $school->jenjang }}</p>
                    </td>
                    <td class="px-6 py-4 text-gray-400 font-mono">{{ $school->npsn }}</td>
                    <td class="px-6 py-4 text-white font-mono text-xs">{{ $school->school_code }}</td>
                    <td class="px-6 py-4 text-gray-400">{{ $school->kota }}, {{ $school->provinsi }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                            {{ $school->status === 'aktif' ? 'bg-green-500/10 text-green-400' : '' }}
                            {{ $school->status === 'pending' ? 'bg-yellow-500/10 text-yellow-400' : '' }}
                            {{ $school->status === 'nonaktif' ? 'bg-gray-500/10 text-gray-400' : '' }}
                            {{ $school->status === 'ditolak' ? 'bg-red-500/10 text-red-400' : '' }}">
                            {{ ucfirst($school->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-400 text-xs">
                        {{ $school->license ? ucfirst($school->license->tipe_lisensi) : '-' }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            @if(auth()->user()->isAdminKvt())
                            @if($school->status === 'pending')
                            <form action="{{ route('admin.schools.approve', $school) }}" method="POST" class="inline">
                                @csrf
                                <button class="bg-green-500/10 text-green-400 px-3 py-1.5 rounded-lg text-xs hover:bg-green-500/20 transition-colors">Setujui</button>
                            </form>
                            <form action="{{ route('admin.schools.reject', $school) }}" method="POST" class="inline">
                                @csrf
                                <button class="bg-red-500/10 text-red-400 px-3 py-1.5 rounded-lg text-xs hover:bg-red-500/20 transition-colors">Tolak</button>
                            </form>
                            @else
                            <form action="{{ route('admin.schools.toggle', $school) }}" method="POST" class="inline">
                                @csrf
                                <button class="bg-white/5 text-gray-400 px-3 py-1.5 rounded-lg text-xs hover:bg-white/10 transition-colors">
                                    {{ $school->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>
                            @endif
                            @endif
                            <a href="{{ route('schools.show', $school) }}" class="bg-white/5 text-gray-400 px-3 py-1.5 rounded-lg text-xs hover:bg-white/10 transition-colors">Detail</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-600">Tidak ada sekolah ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($schools->hasPages())
    <div class="px-6 py-4 border-t border-white/5">
        {{ $schools->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection
