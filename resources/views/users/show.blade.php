@extends('layouts.dashboard')

@section('title', $user->nama)
@section('page-title', 'Detail User')
@section('page-subtitle', $user->nama)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Profile Card --}}
    <div class="bg-zinc-950 border border-white/5 rounded-2xl p-8 text-center">
        <div class="w-20 h-20 bg-white/10 rounded-2xl flex items-center justify-center text-3xl font-bold mx-auto mb-4">{{ strtoupper(substr($user->nama, 0, 1)) }}</div>
        <h2 class="text-xl font-bold text-white mb-1">{{ $user->nama }}</h2>
        <p class="text-sm text-gray-500 font-mono mb-3">{{ $user->kvt_email }}</p>
        <span class="inline-block px-3 py-1 rounded-lg text-xs font-bold
            {{ $user->role == 'admin_kvt' ? 'bg-white/10 text-white' : ($user->role == 'admin_sekolah' ? 'bg-white/10 text-gray-300' : ($user->role == 'guru' ? 'bg-white/10 text-gray-300' : 'bg-white/5 text-gray-400')) }}">
            {{ ucfirst(str_replace('_', ' ', $user->role)) }}
        </span>
        <span class="inline-block px-3 py-1 rounded-lg text-xs font-bold ml-1 {{ $user->status == 'aktif' ? 'bg-emerald-500/10 text-emerald-400' : 'bg-red-500/10 text-red-400' }}">
            {{ ucfirst($user->status) }}
        </span>

        <div class="mt-6 pt-6 border-t border-white/5 space-y-3 text-left text-sm">
            @if($user->nisn)<div><span class="text-gray-500">NISN:</span> <span class="text-white font-mono">{{ $user->nisn }}</span></div>@endif
            @if($user->nip)<div><span class="text-gray-500">NIP:</span> <span class="text-white font-mono">{{ $user->nip }}</span></div>@endif
            @if($user->school)<div><span class="text-gray-500">Sekolah:</span> <span class="text-white">{{ $user->school->nama_sekolah }}</span></div>@endif
            <div><span class="text-gray-500">Bergabung:</span> <span class="text-white">{{ $user->created_at->format('d M Y') }}</span></div>
        </div>

        <div class="mt-6 flex gap-2">
            <a href="{{ role_route('users.edit', $user) }}" class="flex-1 bg-white text-black py-2.5 rounded-xl text-sm font-bold hover:bg-gray-200 transition-all text-center">Edit</a>
            <form action="{{ role_route('users.destroy', $user) }}" method="POST" class="flex-1" onsubmit="return confirm('Hapus user ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="w-full border border-red-500/20 text-red-400 py-2.5 rounded-xl text-sm font-medium hover:bg-red-500/10 transition-all">Hapus</button>
            </form>
        </div>
    </div>

    {{-- Content --}}
    <div class="lg:col-span-2 space-y-6">
        {{-- KVT Email Account --}}
        @if($user->kvtEmailAccounts->count())
        <div class="bg-zinc-950 border border-white/5 rounded-2xl p-6">
            <h3 class="font-bold text-white mb-4">Akun Email KVT</h3>
            <div class="space-y-3">
                @foreach($user->kvtEmailAccounts as $email)
                <div class="flex items-center justify-between bg-white/5 rounded-xl p-4">
                    <div>
                        <p class="text-white font-mono text-sm">{{ $email->kvt_email }}</p>
                        <p class="text-gray-500 text-xs">{{ $email->display_name }}</p>
                    </div>
                    <span class="text-xs text-gray-500">{{ $email->created_at->format('d M Y') }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Classes --}}
        @if($user->role == 'siswa' && $user->classes->count())
        <div class="bg-zinc-950 border border-white/5 rounded-2xl p-6">
            <h3 class="font-bold text-white mb-4">Kelas yang Diikuti</h3>
            <div class="space-y-2">
                @foreach($user->classes as $class)
                <div class="flex items-center justify-between bg-white/5 rounded-xl p-4">
                    <div>
                        <p class="text-white text-sm font-semibold">{{ $class->nama_kelas }}</p>
                        <p class="text-gray-500 text-xs">{{ $class->jurusan }} — {{ $class->tahun_ajaran }}</p>
                    </div>
                    <span class="text-xs text-gray-400">Tingkat {{ $class->tingkat }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Recent KVT Scores --}}
        @if($user->role == 'siswa' && $user->kvtScores->count())
        <div class="bg-zinc-950 border border-white/5 rounded-2xl p-6">
            <h3 class="font-bold text-white mb-4">Nilai KVT Terbaru</h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead><tr class="text-xs text-gray-500 border-b border-white/5">
                        <th class="text-left pb-3">Kompetensi</th><th class="text-center pb-3">Nilai</th><th class="text-center pb-3">Predikat</th><th class="text-left pb-3">Semester</th>
                    </tr></thead>
                    <tbody>
                        @foreach($user->kvtScores->take(10) as $score)
                        <tr class="border-b border-white/5">
                            <td class="py-3 text-sm text-white">{{ $score->kompetensi }}</td>
                            <td class="py-3 text-sm text-white text-center font-mono">{{ number_format($score->nilai, 1) }}</td>
                            <td class="py-3 text-center"><span class="px-2 py-0.5 rounded text-xs font-bold bg-white/10 text-white">{{ $score->predikat }}</span></td>
                            <td class="py-3 text-sm text-gray-400">{{ ucfirst($score->semester) }} — {{ $score->tahun_ajaran }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
