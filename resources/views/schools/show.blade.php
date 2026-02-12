@extends('layouts.dashboard')

@section('title', $school->nama_sekolah)
@section('page-title', $school->nama_sekolah)
@section('page-subtitle', 'Detail informasi sekolah')

@section('content')
<div class="grid md:grid-cols-3 gap-6">
    {{-- Main Info --}}
    <div class="md:col-span-2 space-y-6">
        <div class="bg-zinc-950 border border-white/5 rounded-2xl p-6">
            <h3 class="text-white font-bold mb-4">Informasi Sekolah</h3>
            <div class="grid grid-cols-2 gap-4">
                <div><p class="text-gray-600 text-xs mb-1">NPSN</p><p class="text-white font-mono">{{ $school->npsn }}</p></div>
                <div><p class="text-gray-600 text-xs mb-1">School Code</p><p class="text-white font-mono">{{ $school->school_code }}</p></div>
                <div><p class="text-gray-600 text-xs mb-1">Jenjang</p><p class="text-white">{{ $school->jenjang }}</p></div>
                <div><p class="text-gray-600 text-xs mb-1">Status</p>
                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $school->status === 'aktif' ? 'bg-green-500/10 text-green-400' : 'bg-yellow-500/10 text-yellow-400' }}">{{ ucfirst($school->status) }}</span>
                </div>
                <div><p class="text-gray-600 text-xs mb-1">Kota</p><p class="text-white">{{ $school->kota }}</p></div>
                <div><p class="text-gray-600 text-xs mb-1">Provinsi</p><p class="text-white">{{ $school->provinsi }}</p></div>
                <div><p class="text-gray-600 text-xs mb-1">Kepala Sekolah</p><p class="text-white">{{ $school->kepala_sekolah ?? '-' }}</p></div>
                <div><p class="text-gray-600 text-xs mb-1">Telepon</p><p class="text-white">{{ $school->telepon ?? '-' }}</p></div>
                <div class="col-span-2"><p class="text-gray-600 text-xs mb-1">Alamat</p><p class="text-white">{{ $school->alamat ?? '-' }}</p></div>
            </div>
        </div>

        {{-- Users --}}
        <div class="bg-zinc-950 border border-white/5 rounded-2xl p-6">
            <h3 class="text-white font-bold mb-4">Daftar User ({{ $school->users->count() }})</h3>
            <div class="space-y-2">
                @foreach($school->users as $user)
                <div class="flex items-center justify-between py-2 border-b border-white/5 last:border-0">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-xs font-bold text-gray-400">
                            {{ strtoupper(substr($user->nama, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-white text-sm font-medium">{{ $user->nama }}</p>
                            <p class="text-gray-600 text-xs font-mono">{{ $user->kvt_email }}</p>
                        </div>
                    </div>
                    <span class="text-xs px-2 py-1 rounded-full bg-white/5 text-gray-400">{{ ucfirst(str_replace('_', ' ', $user->role)) }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Sidebar --}}
    <div class="space-y-6">
        {{-- License --}}
        <div class="bg-zinc-950 border border-white/5 rounded-2xl p-6">
            <h3 class="text-white font-bold mb-4">Lisensi</h3>
            @if($school->license)
            <div class="space-y-3">
                <div><p class="text-gray-600 text-xs mb-1">Tipe</p><p class="text-white font-bold text-lg">{{ ucfirst($school->license->tipe_lisensi) }}</p></div>
                <div><p class="text-gray-600 text-xs mb-1">Berlaku</p><p class="text-white text-sm">{{ $school->license->berlaku_mulai->format('d M Y') }} — {{ $school->license->berlaku_sampai->format('d M Y') }}</p></div>
                <div><p class="text-gray-600 text-xs mb-1">Status</p>
                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $school->license->status === 'aktif' ? 'bg-green-500/10 text-green-400' : 'bg-red-500/10 text-red-400' }}">{{ ucfirst($school->license->status) }}</span>
                </div>
            </div>
            @else
            <p class="text-gray-600 text-sm">Belum ada lisensi.</p>
            @endif
        </div>

        {{-- Email Accounts --}}
        <div class="bg-zinc-950 border border-white/5 rounded-2xl p-6">
            <h3 class="text-white font-bold mb-4">Akun Email KVT</h3>
            @forelse($school->emailAccounts as $email)
            <div class="py-2 border-b border-white/5 last:border-0">
                <p class="text-white text-sm font-mono">{{ $email->kvt_email }}</p>
                <p class="text-gray-600 text-xs">{{ $email->display_name }}</p>
            </div>
            @empty
            <p class="text-gray-600 text-sm">Belum ada akun email.</p>
            @endforelse
        </div>

        {{-- Actions --}}
        @if(auth()->user()->isAdminKvt())
        <div class="bg-zinc-950 border border-white/5 rounded-2xl p-6">
            <h3 class="text-white font-bold mb-4">Aksi</h3>
            <div class="space-y-2">
                @if($school->status === 'pending')
                <form action="{{ route('admin.schools.approve', $school) }}" method="POST">@csrf
                    <button class="w-full bg-green-500/10 text-green-400 px-4 py-2.5 rounded-lg text-sm hover:bg-green-500/20 transition-colors">Setujui Sekolah</button>
                </form>
                @endif
                <form action="{{ route('admin.schools.toggle', $school) }}" method="POST">@csrf
                    <button class="w-full bg-white/5 text-gray-400 px-4 py-2.5 rounded-lg text-sm hover:bg-white/10 transition-colors">
                        {{ $school->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                    </button>
                </form>
                <form action="{{ route('admin.schools.destroy', $school) }}" method="POST" onsubmit="return confirm('Yakin hapus sekolah ini?')">
                    @csrf @method('DELETE')
                    <button class="w-full bg-red-500/10 text-red-400 px-4 py-2.5 rounded-lg text-sm hover:bg-red-500/20 transition-colors">Hapus Sekolah</button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
