@extends('layouts.dashboard')

@section('title', 'Tools Saya — Edu Tools')
@section('page-title', 'Tools Saya')
@section('page-subtitle', 'Edu tools yang sudah kamu klaim')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    {{-- Stats --}}
    <div class="grid grid-cols-3 gap-4">
        <div class="bg-zinc-900/60 border border-white/5 rounded-xl p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-green-500/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-white">{{ $activeCount }}</p>
                    <p class="text-xs text-gray-500">Aktif</p>
                </div>
            </div>
        </div>
        <div class="bg-zinc-900/60 border border-white/5 rounded-xl p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-yellow-500/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-white">{{ $pendingCount }}</p>
                    <p class="text-xs text-gray-500">Menunggu</p>
                </div>
            </div>
        </div>
        <div class="bg-zinc-900/60 border border-white/5 rounded-xl p-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-500/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-white truncate">{{ $user->kvt_email ?? '-' }}</p>
                    <p class="text-xs text-gray-500">Email KVT</p>
                </div>
            </div>
        </div>
    </div>

    {{-- My Tools List --}}
    @if($myTools->count() > 0)
    <div class="space-y-3">
        @foreach($myTools as $item)
        <div class="bg-zinc-900/60 border border-white/5 rounded-xl p-5 hover:border-white/10 transition-all">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    @if($item->eduTool->icon_url)
                    <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center overflow-hidden flex-shrink-0">
                        <img src="{{ $item->eduTool->icon_url }}" alt="" class="w-8 h-8 object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-xl\'>🔧</span>'">
                    </div>
                    @else
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br {{ $item->eduTool->category_color }} flex items-center justify-center flex-shrink-0">
                        <span class="text-xl">🔧</span>
                    </div>
                    @endif
                    <div>
                        <h3 class="text-white font-bold">{{ $item->eduTool->name }}</h3>
                        <p class="text-gray-500 text-xs">
                            Diklaim {{ $item->claimed_at?->diffForHumans() ?? '-' }}
                            @if($item->expires_at)
                             · Berlaku sampai {{ $item->expires_at->format('d M Y') }}
                            @endif
                        </p>
                        @if($item->notes)
                        <p class="text-yellow-400 text-xs mt-1">📝 {{ $item->notes }}</p>
                        @endif
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    @if($item->status === 'aktif')
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-500/20 text-green-400 border border-green-500/30">Aktif</span>
                    <a href="{{ $item->eduTool->website_url }}" target="_blank" class="px-4 py-2 rounded-lg bg-white/5 text-white text-sm hover:bg-white/10 transition-all border border-white/10">
                        Buka ↗
                    </a>
                    @elseif($item->status === 'pending')
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">Pending</span>
                    @elseif($item->status === 'ditolak')
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-500/20 text-red-400 border border-red-500/30">Ditolak</span>
                    @elseif($item->status === 'expired')
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-gray-500/20 text-gray-400 border border-gray-500/30">Expired</span>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-20 bg-zinc-900/40 rounded-xl border border-white/5">
        <svg class="w-16 h-16 mx-auto text-gray-700 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
        <p class="text-gray-500 text-lg mb-2">Belum ada tools yang diklaim</p>
        <p class="text-gray-600 text-sm mb-4">Jelajahi katalog tools edukasi gratis dan mulai klaim!</p>
        <a href="{{ route(role_route('edu-tools.index')) }}" class="inline-block px-6 py-2 bg-white text-black rounded-lg text-sm font-bold hover:bg-gray-200 transition-all">
            Jelajahi Tools
        </a>
    </div>
    @endif
</div>
@endsection
