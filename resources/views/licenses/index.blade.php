@extends('layouts.dashboard')

@section('title', 'Lisensi KVT')
@section('page-title', 'Lisensi')
@section('page-subtitle', 'Kelola lisensi sekolah')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex justify-between items-center">
        <div></div>
        @if(auth()->user()->role == 'admin_kvt')
        <a href="{{ route('licenses.create') }}" class="bg-white text-black px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-gray-200 transition-all">+ Tambah Lisensi</a>
        @endif
    </div>

    {{-- Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($licenses as $license)
        <div class="bg-zinc-950 border border-white/5 rounded-2xl p-6 hover:border-white/10 transition-all">
            <div class="flex items-center justify-between mb-4">
                <span class="px-3 py-1 rounded-lg text-xs font-black uppercase tracking-wider
                    {{ $license->tipe_lisensi == 'premium' ? 'bg-white text-black' : ($license->tipe_lisensi == 'pro' ? 'bg-white/20 text-white' : 'bg-white/10 text-gray-300') }}">
                    {{ $license->tipe_lisensi }}
                </span>
                @if($license->isActive())
                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-500/10 text-emerald-400">AKTIF</span>
                @elseif($license->isExpired())
                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-red-500/10 text-red-400">EXPIRED</span>
                @endif
            </div>

            <h3 class="text-white font-bold mb-1">{{ $license->school->nama_sekolah ?? 'Sekolah Dihapus' }}</h3>
            <p class="text-gray-500 text-xs font-mono mb-4">{{ $license->school->school_code ?? '-' }}</p>

            <div class="space-y-2 text-sm">
                <div class="flex justify-between"><span class="text-gray-500">Berlaku</span><span class="text-white">{{ $license->berlaku_mulai->format('d M Y') }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Sampai</span><span class="text-white">{{ $license->berlaku_sampai->format('d M Y') }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Sisa</span>
                    <span class="{{ $license->sisaHari() <= 30 ? 'text-red-400' : 'text-white' }} font-bold">
                        {{ $license->isExpired() ? 'Expired' : $license->sisaHari() . ' hari' }}
                    </span>
                </div>
            </div>

            <div class="mt-4 pt-4 border-t border-white/5 grid grid-cols-3 gap-2 text-center">
                <div><p class="text-white font-bold text-sm">{{ $license->max_guru }}</p><p class="text-gray-500 text-[10px]">Guru</p></div>
                <div><p class="text-white font-bold text-sm">{{ $license->max_siswa }}</p><p class="text-gray-500 text-[10px]">Siswa</p></div>
                <div><p class="text-white font-bold text-sm">{{ $license->max_kelas }}</p><p class="text-gray-500 text-[10px]">Kelas</p></div>
            </div>

            @if(auth()->user()->role == 'admin_kvt')
            <div class="mt-4 flex gap-2">
                <a href="{{ route('licenses.edit', $license) }}" class="flex-1 text-center text-gray-500 hover:text-white text-xs py-2 rounded-lg border border-white/10 hover:border-white/30 transition-all">Edit</a>
                <form action="{{ route('licenses.destroy', $license) }}" method="POST" class="flex-1" onsubmit="return confirm('Hapus lisensi ini?')">
                    @csrf @method('DELETE')
                    <button class="w-full text-red-400 hover:text-red-300 text-xs py-2 rounded-lg border border-red-500/20 hover:border-red-500/40 transition-all">Hapus</button>
                </form>
            </div>
            @endif
        </div>
        @empty
        <div class="col-span-full text-center py-12 text-gray-500">Belum ada lisensi.</div>
        @endforelse
    </div>

    @if($licenses->hasPages())
    <div class="mt-4">{{ $licenses->withQueryString()->links() }}</div>
    @endif
</div>
@endsection
