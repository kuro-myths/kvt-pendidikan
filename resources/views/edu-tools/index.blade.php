@extends('layouts.dashboard')

@section('title', 'Edu Tools — Gratis untuk Pelajar')
@section('page-title', 'Edu Tools')
@section('page-subtitle', 'Tools edukasi premium gratis untuk pelajar & guru')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">

    {{-- Stats Bar --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-zinc-900/60 border border-white/5 rounded-xl p-4">
            <p class="text-2xl font-bold text-white">{{ $tools->count() }}</p>
            <p class="text-xs text-gray-500">Tools Tersedia</p>
        </div>
        <div class="bg-zinc-900/60 border border-white/5 rounded-xl p-4">
            <p class="text-2xl font-bold text-green-400">{{ $totalClaimed }}</p>
            <p class="text-xs text-gray-500">Tools Aktif Kamu</p>
        </div>
        <div class="bg-zinc-900/60 border border-white/5 rounded-xl p-4">
            <p class="text-2xl font-bold text-cyan-400">{{ count($categories) }}</p>
            <p class="text-xs text-gray-500">Kategori</p>
        </div>
        <div class="bg-zinc-900/60 border border-white/5 rounded-xl p-4">
            <p class="text-2xl font-bold text-yellow-400">100%</p>
            <p class="text-xs text-gray-500">GRATIS</p>
        </div>
    </div>

    {{-- Search & Filter --}}
    <div class="flex flex-col md:flex-row gap-4">
        <form method="GET" class="flex-1 flex gap-3">
            <div class="flex-1 relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari tools..." class="pl-10 !bg-zinc-900/60 !border-white/10">
            </div>
            @if($category)
            <input type="hidden" name="category" value="{{ $category }}">
            @endif
            <button type="submit" class="bg-white text-black px-5 py-2 rounded-lg text-sm font-semibold hover:bg-gray-200 transition-all">Cari</button>
        </form>
    </div>

    {{-- Category Filter --}}
    <div class="flex flex-wrap gap-2">
        <a href="{{ route(role_route('edu-tools.index')) }}"
           class="px-4 py-2 rounded-full text-sm font-medium transition-all {{ !$category ? 'bg-white text-black' : 'bg-zinc-800 text-gray-400 hover:text-white hover:bg-zinc-700' }}">
            Semua ({{ $tools->count() }})
        </a>
        @foreach($categories as $catKey => $cat)
        <a href="{{ route(role_route('edu-tools.index'), ['category' => $catKey]) }}"
           class="px-4 py-2 rounded-full text-sm font-medium transition-all {{ $category === $catKey ? 'bg-white text-black' : 'bg-zinc-800 text-gray-400 hover:text-white hover:bg-zinc-700' }}">
            {{ $cat['icon'] }} {{ $cat['label'] }} ({{ $cat['count'] }})
        </a>
        @endforeach
    </div>

    {{-- Tools Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($tools as $tool)
        <div class="group bg-zinc-900/60 border border-white/5 rounded-xl overflow-hidden hover:border-white/20 transition-all duration-300 hover:shadow-lg hover:shadow-white/5 flex flex-col">
            {{-- Header with Category Badge --}}
            <div class="relative p-5 pb-3">
                <div class="flex items-start justify-between">
                    <div class="flex items-center gap-3">
                        @if($tool->icon_url)
                        <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center overflow-hidden flex-shrink-0">
                            <img src="{{ $tool->icon_url }}" alt="{{ $tool->name }}" class="w-8 h-8 object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-xl\'>🔧</span>'">
                        </div>
                        @else
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br {{ $tool->category_color }} flex items-center justify-center flex-shrink-0">
                            <span class="text-xl">🔧</span>
                        </div>
                        @endif
                        <div>
                            <h3 class="text-white font-bold text-base group-hover:text-white/90">{{ $tool->name }}</h3>
                            <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-medium bg-gradient-to-r {{ $tool->category_color }} text-white">
                                {{ $tool->category_label }}
                            </span>
                        </div>
                    </div>

                    {{-- Status --}}
                    @if(in_array($tool->id, $claimedToolIds))
                        @php $status = $claimStatuses[$tool->id] ?? 'pending'; @endphp
                        @if($status === 'aktif')
                        <span class="px-2 py-1 rounded-full text-[10px] font-bold bg-green-500/20 text-green-400 border border-green-500/30">AKTIF</span>
                        @elseif($status === 'pending')
                        <span class="px-2 py-1 rounded-full text-[10px] font-bold bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">PENDING</span>
                        @endif
                    @endif
                </div>
            </div>

            {{-- Description --}}
            <div class="px-5 pb-3 flex-1">
                <p class="text-gray-400 text-sm leading-relaxed">{{ $tool->short_description }}</p>
            </div>

            {{-- Benefits Preview --}}
            @if($tool->benefits && count($tool->benefits) > 0)
            <div class="px-5 pb-3">
                <div class="flex flex-wrap gap-1">
                    @foreach(array_slice($tool->benefits, 0, 3) as $benefit)
                    <span class="inline-block px-2 py-0.5 rounded text-[10px] bg-white/5 text-gray-400">{{ \Illuminate\Support\Str::limit($benefit, 30) }}</span>
                    @endforeach
                    @if(count($tool->benefits) > 3)
                    <span class="inline-block px-2 py-0.5 rounded text-[10px] bg-white/5 text-gray-500">+{{ count($tool->benefits) - 3 }} lainnya</span>
                    @endif
                </div>
            </div>
            @endif

            {{-- Actions --}}
            <div class="p-5 pt-3 border-t border-white/5 flex items-center gap-2 mt-auto">
                <a href="{{ route(role_route('edu-tools.show'), $tool) }}" class="flex-1 text-center py-2 rounded-lg bg-white/5 text-white text-sm font-medium hover:bg-white/10 transition-all">
                    Detail
                </a>
                @if(!in_array($tool->id, $claimedToolIds))
                <form action="{{ route(role_route('edu-tools.claim'), $tool) }}" method="POST" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full py-2 rounded-lg bg-white text-black text-sm font-semibold hover:bg-gray-200 transition-all">
                        Klaim Gratis
                    </button>
                </form>
                @else
                <a href="{{ $tool->website_url }}" target="_blank" class="flex-1 text-center py-2 rounded-lg bg-emerald-500/20 text-emerald-400 text-sm font-medium hover:bg-emerald-500/30 transition-all border border-emerald-500/20">
                    Buka Tool ↗
                </a>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-16">
            <p class="text-gray-500 text-lg">Tidak ada tools ditemukan.</p>
            <a href="{{ route(role_route('edu-tools.index')) }}" class="text-white underline text-sm mt-2 inline-block">Reset filter</a>
        </div>
        @endforelse
    </div>

    {{-- Info Box --}}
    <div class="bg-gradient-to-r from-zinc-900 to-zinc-800 border border-white/10 rounded-xl p-6">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-full bg-blue-500/20 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <h4 class="text-white font-bold mb-1">Cara Mendapatkan Edu Tools Gratis</h4>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Semua tools di atas tersedia GRATIS untuk pelajar dan guru yang terdaftar di Universe KVT.
                    Cukup klik "Klaim Gratis", lalu ikuti panduan verifikasi menggunakan email KVT kamu
                    (<span class="text-white font-medium">{{ $user->kvt_email ?? 'belum ada' }}</span>).
                    Setelah diverifikasi, kamu bisa langsung menggunakan tools tersebut!
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
