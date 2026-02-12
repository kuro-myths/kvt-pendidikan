@extends('layouts.dashboard')

@section('title', $eduTool->name . ' — Edu Tools')
@section('page-title', $eduTool->name)
@section('page-subtitle', $eduTool->category_label)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Back Button --}}
    <a href="{{ route(role_route('edu-tools.index')) }}" class="inline-flex items-center gap-2 text-gray-400 hover:text-white text-sm transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali ke Katalog
    </a>

    {{-- Hero Card --}}
    <div class="bg-zinc-900/60 border border-white/10 rounded-2xl overflow-hidden">
        <div class="bg-gradient-to-r {{ $eduTool->category_color }} p-6">
            <div class="flex items-center gap-4">
                @if($eduTool->icon_url)
                <div class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center overflow-hidden">
                    <img src="{{ $eduTool->icon_url }}" alt="{{ $eduTool->name }}" class="w-10 h-10 object-contain" onerror="this.parentElement.innerHTML='<span class=\'text-2xl\'>🔧</span>'">
                </div>
                @else
                <div class="w-16 h-16 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center">
                    <span class="text-2xl">🔧</span>
                </div>
                @endif
                <div>
                    <h1 class="text-2xl font-black text-white">{{ $eduTool->name }}</h1>
                    <p class="text-white/80 text-sm">{{ $eduTool->short_description }}</p>
                </div>
            </div>
        </div>

        <div class="p-6 space-y-6">
            {{-- Status & Actions --}}
            <div class="flex flex-wrap items-center gap-3">
                @if($claimStatus === 'aktif')
                <span class="px-4 py-2 rounded-full text-sm font-bold bg-green-500/20 text-green-400 border border-green-500/30 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Aktif
                </span>
                @elseif($claimStatus === 'pending')
                <span class="px-4 py-2 rounded-full text-sm font-bold bg-yellow-500/20 text-yellow-400 border border-yellow-500/30 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Menunggu Verifikasi
                </span>
                @elseif($claimStatus === 'ditolak')
                <span class="px-4 py-2 rounded-full text-sm font-bold bg-red-500/20 text-red-400 border border-red-500/30">Ditolak</span>
                @endif

                @if(!$claimStatus || $claimStatus === 'ditolak' || $claimStatus === 'expired')
                <form action="{{ route(role_route('edu-tools.claim'), $eduTool) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-6 py-2 bg-white text-black rounded-lg text-sm font-bold hover:bg-gray-200 transition-all">
                        🎁 Klaim Gratis Sekarang
                    </button>
                </form>
                @endif

                <a href="{{ $eduTool->website_url }}" target="_blank" class="px-4 py-2 bg-white/5 text-white rounded-lg text-sm hover:bg-white/10 transition-all flex items-center gap-2 border border-white/10">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Kunjungi Website
                </a>

                <span class="text-gray-500 text-xs">{{ $totalClaimers }} pelajar sudah klaim</span>
            </div>

            {{-- Claim Info --}}
            @if($claimRecord)
            <div class="bg-zinc-800/50 rounded-xl p-4 border border-white/5">
                <h4 class="text-white font-semibold text-sm mb-2">Info Klaim Kamu</h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                    <div>
                        <p class="text-gray-500 text-xs">Email Digunakan</p>
                        <p class="text-white">{{ $claimRecord->kvt_email_used ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs">Tanggal Klaim</p>
                        <p class="text-white">{{ $claimRecord->claimed_at?->format('d M Y') ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs">Berlaku Sampai</p>
                        <p class="text-white">{{ $claimRecord->expires_at?->format('d M Y') ?? 'Selamanya' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs">Status</p>
                        <p class="text-white capitalize">{{ $claimRecord->status }}</p>
                    </div>
                </div>
                @if($claimRecord->notes)
                <p class="text-yellow-400 text-xs mt-2">📝 {{ $claimRecord->notes }}</p>
                @endif
            </div>
            @endif

            {{-- Description --}}
            <div>
                <h3 class="text-white font-bold text-lg mb-2">Deskripsi</h3>
                <p class="text-gray-400 leading-relaxed">{{ $eduTool->description }}</p>
            </div>

            {{-- Benefits --}}
            @if($eduTool->benefits && count($eduTool->benefits) > 0)
            <div>
                <h3 class="text-white font-bold text-lg mb-3">Yang Kamu Dapatkan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    @foreach($eduTool->benefits as $benefit)
                    <div class="flex items-start gap-2 bg-white/5 rounded-lg p-3">
                        <svg class="w-5 h-5 text-green-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span class="text-gray-300 text-sm">{{ $benefit }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- How to Claim --}}
            @if($eduTool->how_to_claim)
            <div>
                <h3 class="text-white font-bold text-lg mb-3">Cara Klaim & Aktivasi</h3>
                <div class="bg-zinc-800/50 rounded-xl p-5 border border-white/5">
                    <div class="space-y-2">
                        @foreach(explode("\n", $eduTool->how_to_claim) as $step)
                        @if(trim($step))
                        <p class="text-gray-300 text-sm flex items-start gap-2">
                            <span class="text-cyan-400 font-bold">→</span>
                            {{ trim($step) }}
                        </p>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            {{-- Requirements --}}
            @if($eduTool->requirements && count($eduTool->requirements) > 0)
            <div>
                <h3 class="text-white font-bold text-lg mb-3">Persyaratan</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($eduTool->requirements as $req)
                    <span class="px-3 py-1.5 rounded-lg bg-orange-500/10 text-orange-400 text-sm border border-orange-500/20">
                        {{ $req }}
                    </span>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Email Info --}}
            <div class="bg-gradient-to-r from-blue-500/10 to-cyan-500/10 rounded-xl p-5 border border-blue-500/20">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-blue-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <div>
                        <h4 class="text-white font-bold text-sm">Email KVT Kamu</h4>
                        <p class="text-blue-300 font-mono text-lg mt-1">{{ $user->kvt_email ?? 'Belum memiliki email KVT' }}</p>
                        <p class="text-gray-400 text-xs mt-1">Gunakan email ini untuk verifikasi dan mendapatkan benefit edukasi gratis</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
