@extends('layouts.app')

@section('title', 'Universe KVT')

@push('styles')
<style>
    .parallax-layer { will-change: transform; }
    .particle { position: absolute; width: 2px; height: 2px; background: rgba(255,255,255,0.3); border-radius: 50%; pointer-events: none; }
    .meteor { position: absolute; width: 120px; height: 1px; background: linear-gradient(90deg, rgba(255,255,255,0.6), transparent); transform: rotate(-45deg); pointer-events: none; opacity: 0; }
    .glow-orb { position: absolute; border-radius: 50%; filter: blur(80px); pointer-events: none; will-change: transform; }
    .marquee { display: flex; gap: 4rem; animation: marquee 25s linear infinite; }
    @keyframes marquee { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
    .float { animation: float 6s ease-in-out infinite; }
    .float-delay { animation-delay: 2s; }
    .float-delay-2 { animation-delay: 4s; }
    @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-20px); } }
    .neon-line { height: 1px; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent); }
    .shine { position: relative; overflow: hidden; }
    .shine::after { content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: linear-gradient(135deg, transparent 40%, rgba(255,255,255,0.05) 50%, transparent 60%); animation: shine 4s infinite; }
    @keyframes shine { 0% { transform: translateX(-100%) translateY(-100%); } 100% { transform: translateX(100%) translateY(100%); } }
    .scroll-progress { position: fixed; top: 0; left: 0; height: 2px; background: white; z-index: 100; transform-origin: left; }
    .counter { font-variant-numeric: tabular-nums; }
</style>
@endpush

@section('content')
{{-- SCROLL PROGRESS BAR --}}
<div class="scroll-progress" id="scrollProgress"></div>

{{-- FLOATING PARTICLES CANVAS --}}
<canvas id="particleCanvas" class="fixed inset-0 pointer-events-none z-0" style="opacity: 0.4;"></canvas>

{{-- NAVBAR --}}
<nav class="fixed top-0 w-full z-50 transition-all duration-500" id="navbar" x-data="{ open: false, scrolled: false }" @scroll.window="scrolled = (window.scrollY > 80)">
    <div class="absolute inset-0 transition-all duration-500" :class="scrolled ? 'bg-black/80 backdrop-blur-2xl border-b border-white/5' : 'bg-transparent'"></div>
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between relative z-10">
        <a href="{{ route('landing') }}" class="flex items-center gap-3 group">
            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <span class="text-black font-black text-sm">KVT</span>
            </div>
            <span class="text-white font-bold text-xl">Universe <span class="text-gray-500 font-light">KVT</span></span>
        </a>
        <div class="hidden md:flex items-center gap-8">
            <a href="#features" class="text-gray-400 hover:text-white transition-colors text-sm relative group">Fitur<span class="absolute -bottom-1 left-0 w-0 h-px bg-white group-hover:w-full transition-all duration-300"></span></a>
            <a href="#preview" class="text-gray-400 hover:text-white transition-colors text-sm relative group">Preview<span class="absolute -bottom-1 left-0 w-0 h-px bg-white group-hover:w-full transition-all duration-300"></span></a>
            <a href="#how" class="text-gray-400 hover:text-white transition-colors text-sm relative group">Cara Kerja<span class="absolute -bottom-1 left-0 w-0 h-px bg-white group-hover:w-full transition-all duration-300"></span></a>
            <a href="#testimonials" class="text-gray-400 hover:text-white transition-colors text-sm relative group">Testimoni<span class="absolute -bottom-1 left-0 w-0 h-px bg-white group-hover:w-full transition-all duration-300"></span></a>
            <a href="#pricing" class="text-gray-400 hover:text-white transition-colors text-sm relative group">Lisensi<span class="absolute -bottom-1 left-0 w-0 h-px bg-white group-hover:w-full transition-all duration-300"></span></a>
            <a href="{{ route('login') }}" class="text-gray-400 hover:text-white transition-colors text-sm">Masuk</a>
            <a href="{{ route('register') }}" class="bg-white text-black px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-200 transition-all hover:scale-105">Daftar Sekolah</a>
        </div>
        <button @click="open = !open" class="md:hidden text-white"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg></button>
    </div>
    <div x-show="open" x-transition class="md:hidden border-t border-white/5 bg-black/95 backdrop-blur-xl px-6 py-4 space-y-3 relative z-10">
        <a href="#features" class="block text-gray-400 hover:text-white text-sm py-2">Fitur</a>
        <a href="#preview" class="block text-gray-400 hover:text-white text-sm py-2">Preview</a>
        <a href="#how" class="block text-gray-400 hover:text-white text-sm py-2">Cara Kerja</a>
        <a href="#pricing" class="block text-gray-400 hover:text-white text-sm py-2">Harga</a>
        <a href="{{ route('login') }}" class="block text-gray-400 hover:text-white text-sm py-2">Masuk</a>
        <a href="{{ route('register') }}" class="block bg-white text-black px-5 py-2.5 rounded-lg text-sm font-semibold text-center">Daftar Sekolah</a>
    </div>
</nav>

{{-- ==================== HERO SECTION ==================== --}}
<section class="min-h-screen flex items-center justify-center relative overflow-hidden pt-20" id="hero">
    <div class="absolute inset-0 parallax-layer" data-speed="0.1">
        <div class="absolute inset-0 opacity-[0.03]" style="background-image: linear-gradient(rgba(255,255,255,.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.1) 1px, transparent 1px); background-size: 80px 80px;"></div>
    </div>
    <div class="absolute inset-0 parallax-layer" data-speed="0.2">
        <div class="glow-orb w-[600px] h-[600px] bg-purple-500/[0.03] top-1/4 -left-48 float"></div>
        <div class="glow-orb w-[500px] h-[500px] bg-blue-500/[0.03] bottom-1/4 -right-32 float float-delay"></div>
        <div class="glow-orb w-[400px] h-[400px] bg-white/[0.02] top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 float float-delay-2"></div>
    </div>
    <div class="absolute inset-0 parallax-layer" data-speed="0.3">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[1000px] h-[1000px] bg-[radial-gradient(circle_at_center,rgba(255,255,255,0.04)_0%,transparent_60%)]"></div>
    </div>

    <div class="meteor" id="meteor1" style="top: 15%; left: 60%;"></div>
    <div class="meteor" id="meteor2" style="top: 35%; left: 80%;"></div>
    <div class="meteor" id="meteor3" style="top: 55%; left: 40%;"></div>

    <div class="max-w-6xl mx-auto px-6 text-center relative z-10">
        <div class="hero-badge fade-in">
            <div class="inline-flex items-center gap-2 bg-white/5 border border-white/10 rounded-full px-6 py-3 mb-8 backdrop-blur-sm hover:bg-white/10 transition-all cursor-default">
                <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                <span class="text-gray-400 text-sm">Platform Pendidikan Resmi Berbasis KVT</span>
                <span class="bg-white/10 text-gray-300 text-xs px-2.5 py-0.5 rounded-full font-mono">v2.0</span>
            </div>
        </div>

        <h1 class="hero-title text-6xl md:text-8xl lg:text-9xl font-black leading-[0.85] mb-8 tracking-tighter">
            <span class="block gradient-text" id="heroLine1">Universe</span>
            <span class="block text-white" id="heroLine2">KVT</span>
        </h1>

        <p class="hero-desc text-gray-400 text-lg md:text-xl max-w-2xl mx-auto mb-12 leading-relaxed fade-in">
            Platform pusat pendidikan berbasis <span class="text-white font-medium">Kompetensi Vokasi Terpadu</span>.
            Kelola sekolah, guru, siswa, dan penilaian dalam satu ekosistem digital yang resmi dan terverifikasi.
        </p>

        <div class="hero-buttons fade-in flex flex-col sm:flex-row items-center justify-center gap-4 mb-20">
            <a href="{{ route('register') }}" class="group bg-white text-black px-10 py-4 rounded-xl text-base font-bold hover:bg-gray-200 transition-all hover:scale-105 flex items-center gap-3 shadow-xl shadow-white/10">
                Daftarkan Sekolah
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </a>
            <a href="{{ route('login') }}" class="border border-gray-700 text-white px-10 py-4 rounded-xl text-base font-semibold hover:border-white transition-all hover:bg-white/5 flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4M10 17l5-5-5-5M13.8 12H3"/></svg>
                Masuk ke Akun
            </a>
        </div>

        <div class="hero-stats grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 max-w-4xl mx-auto fade-in">
            <div class="bg-zinc-950/80 border border-white/5 rounded-2xl px-5 py-6 hover:border-white/15 transition-all group shine">
                <p class="text-4xl font-black text-white counter" data-target="100">0</p>
                <p class="text-xs text-gray-500 mt-2 group-hover:text-gray-400 transition-colors">Sekolah Terdaftar</p>
            </div>
            <div class="bg-zinc-950/80 border border-white/5 rounded-2xl px-5 py-6 hover:border-white/15 transition-all group shine">
                <p class="text-4xl font-black text-white counter" data-target="5000" data-suffix="+">0</p>
                <p class="text-xs text-gray-500 mt-2 group-hover:text-gray-400 transition-colors">Siswa Aktif</p>
            </div>
            <div class="bg-zinc-950/80 border border-white/5 rounded-2xl px-5 py-6 hover:border-white/15 transition-all group shine">
                <p class="text-4xl font-black text-white counter" data-target="50000" data-suffix="+">0</p>
                <p class="text-xs text-gray-500 mt-2 group-hover:text-gray-400 transition-colors">Nilai Tercatat</p>
            </div>
            <div class="bg-zinc-950/80 border border-white/5 rounded-2xl px-5 py-6 hover:border-white/15 transition-all group shine">
                <p class="text-4xl font-black text-white font-mono">@kvt.id</p>
                <p class="text-xs text-gray-500 mt-2 group-hover:text-gray-400 transition-colors">Email Resmi</p>
            </div>
        </div>
    </div>

    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2">
        <span class="text-gray-600 text-[10px] uppercase tracking-[0.3em]">Scroll</span>
        <div class="w-5 h-8 border border-gray-700 rounded-full flex justify-center pt-1.5">
            <div class="w-1 h-2 bg-white/50 rounded-full animate-bounce"></div>
        </div>
    </div>
</section>

{{-- ==================== MARQUEE PARTNERS ==================== --}}
<section class="py-12 border-y border-white/5 overflow-hidden relative">
    <div class="absolute inset-0 bg-gradient-to-r from-black via-transparent to-black z-10 pointer-events-none"></div>
    <p class="text-center text-gray-600 text-xs uppercase tracking-[0.3em] mb-8 relative z-20">Dipercaya oleh institusi pendidikan di seluruh Indonesia</p>
    <div class="overflow-hidden">
        <div class="marquee">
            @for($i = 0; $i < 2; $i++)
            @foreach(['Kemendikbud', 'BSNP', 'BNSP', 'Dirjen SMK', 'LPTK', 'Kemdikbud Ristek', 'P2G', 'PGRI'] as $partner)
            <div class="flex items-center gap-3 flex-shrink-0 opacity-40 hover:opacity-80 transition-opacity">
                <div class="w-10 h-10 bg-white/5 rounded-xl flex items-center justify-center border border-white/5">
                    <span class="text-white text-xs font-bold">{{ substr($partner, 0, 2) }}</span>
                </div>
                <span class="text-white text-sm font-medium whitespace-nowrap">{{ $partner }}</span>
            </div>
            @endforeach
            @endfor
        </div>
    </div>
</section>

{{-- ==================== FEATURES ==================== --}}
<section id="features" class="py-32 relative overflow-hidden">
    <div class="absolute inset-0 parallax-layer" data-speed="-0.1">
        <div class="glow-orb w-[500px] h-[500px] bg-blue-500/[0.02] -top-48 right-0"></div>
    </div>
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="text-center mb-20">
            <p class="fade-in text-gray-500 text-sm uppercase tracking-[0.4em] mb-4 font-mono">// FITUR PLATFORM</p>
            <h2 class="fade-in text-4xl md:text-6xl font-black text-white mb-5">Semua yang Anda<br><span class="gradient-text">Butuhkan</span></h2>
            <p class="fade-in text-gray-500 max-w-xl mx-auto text-lg">Sistem lengkap untuk mengelola pendidikan KVT dari pendaftaran sampai penilaian.</p>
            <div class="neon-line max-w-xs mx-auto mt-10"></div>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
            @php $features = [
                ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>', 'title' => 'Registrasi Sekolah Otomatis', 'desc' => 'Sekolah mendaftar dengan NPSN, sistem otomatis membuat School ID, akun admin, dan ruang data.', 'tag' => 'AUTO'],
                ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>', 'title' => 'Email @kvt.id Resmi', 'desc' => 'Setiap user mendapat email resmi format rizki@kvt.1, budi@kvt.2 berdasarkan kode sekolah.', 'tag' => 'EMAIL'],
                ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>', 'title' => 'Penilaian KVT Lengkap', 'desc' => 'Input nilai per kompetensi, semester, dan tahun ajaran. Predikat otomatis A-E dengan analytics.', 'tag' => 'GRADE'],
                ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>', 'title' => 'Sistem Lisensi', 'desc' => 'Tiga tingkat lisensi: Basic, Pro, Premium dengan kuota dan masa berlaku yang jelas.', 'tag' => 'LICENSE'],
                ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>', 'title' => 'Role-Based Access', 'desc' => '4 peran: Admin KVT, Admin Sekolah, Guru, Siswa. Masing-masing dashboard dan akses terpisah.', 'tag' => 'RBAC'],
                ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>', 'title' => 'REST API', 'desc' => 'API terenkripsi berbasis School ID untuk integrasi dengan LMS atau sistem eksternal.', 'tag' => 'API'],
                ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>', 'title' => 'Activity Log', 'desc' => 'Semua aktivitas tercatat lengkap: login, perubahan data, hapus, dengan IP dan timestamp.', 'tag' => 'LOG'],
                ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>', 'title' => 'OAuth Login', 'desc' => 'Login menggunakan GitHub atau Google OAuth selain email @kvt.id. Integrasi akun mudah.', 'tag' => 'OAUTH'],
                ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>', 'title' => 'Responsive & Dark', 'desc' => 'Tampilan optimal di semua perangkat. Dark mode elegant dengan animasi parallax.', 'tag' => 'UI/UX'],
            ]; @endphp

            @foreach($features as $idx => $f)
            <div class="fade-in card-hover bg-zinc-950/80 border border-white/5 rounded-2xl p-8 group relative overflow-hidden hover:border-white/15" style="transition-delay: {{ $idx * 50 }}ms;">
                <div class="absolute -top-20 -right-20 w-40 h-40 bg-white/[0.02] rounded-full blur-2xl group-hover:bg-white/[0.05] transition-all duration-700"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-5">
                        <div class="w-12 h-12 bg-white/5 rounded-xl flex items-center justify-center group-hover:bg-white/10 transition-colors duration-300">
                            <svg class="w-6 h-6 text-gray-400 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $f['icon'] !!}</svg>
                        </div>
                        <span class="text-[10px] font-mono text-gray-600 tracking-widest bg-white/5 px-2 py-1 rounded group-hover:text-gray-400 transition-colors">{{ $f['tag'] }}</span>
                    </div>
                    <h3 class="text-white font-bold text-lg mb-2 group-hover:translate-x-1 transition-transform duration-300">{{ $f['title'] }}</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">{{ $f['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ==================== DASHBOARD PREVIEW ==================== --}}
<section id="preview" class="py-32 relative overflow-hidden">
    <div class="absolute inset-0 parallax-layer" data-speed="0.05">
        <div class="absolute inset-0 opacity-[0.015]" style="background-image: linear-gradient(rgba(255,255,255,.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.1) 1px, transparent 1px); background-size: 40px 40px;"></div>
    </div>
    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="text-center mb-16">
            <p class="fade-in text-gray-500 text-sm uppercase tracking-[0.4em] mb-4 font-mono">// DASHBOARD PREVIEW</p>
            <h2 class="fade-in text-4xl md:text-6xl font-black text-white mb-5">Intuitif &<br><span class="gradient-text">Powerful</span></h2>
            <p class="fade-in text-gray-500 max-w-xl mx-auto text-lg">Dashboard dirancang khusus untuk setiap peran pengguna</p>
        </div>

        <div class="scale-in" x-data="{ activeTab: 'admin_kvt' }">
            <div class="flex flex-wrap justify-center gap-2 mb-8">
                @foreach(['admin_kvt' => 'Admin KVT', 'admin_sekolah' => 'Admin Sekolah', 'guru' => 'Guru', 'siswa' => 'Siswa'] as $key => $label)
                <button @click="activeTab = '{{ $key }}'" :class="activeTab === '{{ $key }}' ? 'bg-white text-black shadow-lg shadow-white/10' : 'bg-white/5 text-gray-400 hover:text-white hover:bg-white/10'" class="px-6 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300">{{ $label }}</button>
                @endforeach
            </div>

            {{-- Admin KVT --}}
            <div x-show="activeTab === 'admin_kvt'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0" class="bg-zinc-950 border border-white/10 rounded-2xl overflow-hidden shadow-2xl shadow-black/50">
                <div class="flex">
                    <div class="hidden md:block w-56 bg-zinc-950 border-r border-white/5 p-4">
                        <div class="flex items-center gap-2 px-3 py-2 mb-4"><div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center"><span class="text-black font-black text-xs">KVT</span></div><span class="text-white font-bold text-sm">Universe</span></div>
                        <div class="space-y-1"><div class="px-3 py-2 bg-white/10 rounded-lg text-white text-xs flex items-center gap-2"><span class="w-1.5 h-1.5 bg-white rounded-full"></span> Dashboard</div><div class="px-3 py-2 text-gray-500 text-xs">Kelola Sekolah</div><div class="px-3 py-2 text-gray-500 text-xs">Lisensi</div><div class="px-3 py-2 text-gray-500 text-xs">Semua User</div><div class="px-3 py-2 text-gray-500 text-xs">Activity Log</div></div>
                    </div>
                    <div class="flex-1 p-6">
                        <div class="flex items-center justify-between mb-6"><div><h3 class="text-white font-bold text-lg">Dashboard Admin KVT</h3><p class="text-gray-500 text-xs">Ringkasan seluruh platform</p></div><span class="text-xs text-gray-600 bg-white/5 px-3 py-1 rounded-full font-mono">admin_kvt</span></div>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
                            <div class="bg-white/5 rounded-xl p-4"><p class="text-2xl font-bold text-white">127</p><p class="text-gray-500 text-xs mt-1">Sekolah</p></div>
                            <div class="bg-white/5 rounded-xl p-4"><p class="text-2xl font-bold text-green-400">98</p><p class="text-gray-500 text-xs mt-1">Aktif</p></div>
                            <div class="bg-white/5 rounded-xl p-4"><p class="text-2xl font-bold text-yellow-400">12</p><p class="text-gray-500 text-xs mt-1">Pending</p></div>
                            <div class="bg-white/5 rounded-xl p-4"><p class="text-2xl font-bold text-white">5,243</p><p class="text-gray-500 text-xs mt-1">Total User</p></div>
                        </div>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="bg-white/5 rounded-xl p-4"><p class="text-gray-500 text-xs uppercase tracking-wider mb-3">Sekolah Pending</p><div class="space-y-2"><div class="flex items-center justify-between"><span class="text-white text-xs">SMK Negeri 3 Bandung</span><span class="bg-yellow-500/20 text-yellow-400 text-[10px] px-2 py-0.5 rounded-full">Pending</span></div><div class="flex items-center justify-between"><span class="text-white text-xs">SMA IT Al-Ikhlas</span><span class="bg-yellow-500/20 text-yellow-400 text-[10px] px-2 py-0.5 rounded-full">Pending</span></div><div class="flex items-center justify-between"><span class="text-white text-xs">SMK Muhammadiyah 1</span><span class="bg-yellow-500/20 text-yellow-400 text-[10px] px-2 py-0.5 rounded-full">Pending</span></div></div></div>
                            <div class="bg-white/5 rounded-xl p-4"><p class="text-gray-500 text-xs uppercase tracking-wider mb-3">Aktivitas Terbaru</p><div class="space-y-2"><div class="flex items-center gap-2"><span class="bg-green-500/20 text-green-400 text-[10px] px-2 py-0.5 rounded-full">login</span><span class="text-gray-400 text-xs">Admin SMKN1 login</span></div><div class="flex items-center gap-2"><span class="bg-blue-500/20 text-blue-400 text-[10px] px-2 py-0.5 rounded-full">create</span><span class="text-gray-400 text-xs">User baru ditambahkan</span></div><div class="flex items-center gap-2"><span class="bg-yellow-500/20 text-yellow-400 text-[10px] px-2 py-0.5 rounded-full">update</span><span class="text-gray-400 text-xs">Nilai diperbarui</span></div></div></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Admin Sekolah --}}
            <div x-show="activeTab === 'admin_sekolah'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0" class="bg-zinc-950 border border-white/10 rounded-2xl overflow-hidden shadow-2xl shadow-black/50 p-6 md:p-8">
                <div class="flex items-center justify-between mb-6"><div><h3 class="text-white font-bold text-lg">Dashboard Admin Sekolah</h3><p class="text-gray-500 text-xs">SMKN 1 Surabaya &bull; kvt.1</p></div><span class="text-xs text-gray-600 bg-white/5 px-3 py-1 rounded-full font-mono">admin_sekolah</span></div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6"><div class="bg-white/5 rounded-xl p-4"><p class="text-2xl font-bold text-white">24</p><p class="text-gray-500 text-xs mt-1">Guru</p></div><div class="bg-white/5 rounded-xl p-4"><p class="text-2xl font-bold text-white">487</p><p class="text-gray-500 text-xs mt-1">Siswa</p></div><div class="bg-white/5 rounded-xl p-4"><p class="text-2xl font-bold text-white">18</p><p class="text-gray-500 text-xs mt-1">Kelas</p></div><div class="bg-green-500/10 rounded-xl p-4"><div class="flex items-center gap-1"><p class="text-lg font-bold text-green-400">Pro</p><span class="text-green-400 text-[10px]">Aktif</span></div><p class="text-gray-500 text-xs mt-1">Lisensi</p></div></div>
                <div class="bg-white/5 rounded-xl p-4"><p class="text-gray-500 text-xs uppercase tracking-wider mb-3">Siswa Terbaru</p><div class="space-y-2"><div class="flex items-center gap-3"><div class="w-6 h-6 bg-green-500/20 rounded-full flex items-center justify-center text-[10px] font-bold text-green-400">R</div><span class="text-white text-xs">Rizki Pratama</span><span class="text-gray-600 text-[10px] font-mono ml-auto">12345.rizki@kvt.1</span></div><div class="flex items-center gap-3"><div class="w-6 h-6 bg-green-500/20 rounded-full flex items-center justify-center text-[10px] font-bold text-green-400">S</div><span class="text-white text-xs">Siti Nurhaliza</span><span class="text-gray-600 text-[10px] font-mono ml-auto">67890.siti@kvt.1</span></div></div></div>
            </div>

            {{-- Guru --}}
            <div x-show="activeTab === 'guru'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0" class="bg-zinc-950 border border-white/10 rounded-2xl overflow-hidden shadow-2xl shadow-black/50 p-6 md:p-8">
                <div class="flex items-center justify-between mb-6"><div><h3 class="text-white font-bold text-lg">Dashboard Guru</h3><p class="text-gray-500 text-xs">Budi Santoso &bull; budi.santoso@kvt.1</p></div><span class="text-xs text-gray-600 bg-white/5 px-3 py-1 rounded-full font-mono">guru</span></div>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mb-6"><div class="bg-white/5 rounded-xl p-4"><p class="text-2xl font-bold text-white">3</p><p class="text-gray-500 text-xs mt-1">Kelas Diajar</p></div><div class="bg-white/5 rounded-xl p-4"><p class="text-2xl font-bold text-white">156</p><p class="text-gray-500 text-xs mt-1">Nilai Tercatat</p></div><div class="bg-white/5 rounded-xl p-4"><p class="text-2xl font-bold text-white">89</p><p class="text-gray-500 text-xs mt-1">Siswa</p></div></div>
                <div class="bg-white/5 rounded-xl p-4"><p class="text-gray-500 text-xs uppercase tracking-wider mb-3">Nilai Terbaru</p><table class="w-full text-xs"><thead><tr class="text-gray-600"><th class="text-left py-2">Siswa</th><th class="text-left py-2">Kompetensi</th><th class="text-right py-2">Nilai</th><th class="text-right py-2">Predikat</th></tr></thead><tbody class="text-gray-300"><tr><td class="py-1.5">Rizki Pratama</td><td>Pemrograman Web</td><td class="text-right font-bold text-green-400">92</td><td class="text-right"><span class="bg-green-500/20 text-green-400 text-[10px] px-1.5 py-0.5 rounded">A</span></td></tr><tr><td class="py-1.5">Siti Aminah</td><td>Database</td><td class="text-right font-bold text-blue-400">85</td><td class="text-right"><span class="bg-blue-500/20 text-blue-400 text-[10px] px-1.5 py-0.5 rounded">B</span></td></tr><tr><td class="py-1.5">Ahmad Fauzi</td><td>Jaringan</td><td class="text-right font-bold text-yellow-400">73</td><td class="text-right"><span class="bg-yellow-500/20 text-yellow-400 text-[10px] px-1.5 py-0.5 rounded">C</span></td></tr></tbody></table></div>
            </div>

            {{-- Siswa --}}
            <div x-show="activeTab === 'siswa'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0" class="bg-zinc-950 border border-white/10 rounded-2xl overflow-hidden shadow-2xl shadow-black/50 p-6 md:p-8">
                <div class="flex items-center justify-between mb-6"><div><h3 class="text-white font-bold text-lg">Dashboard Siswa</h3><p class="text-gray-500 text-xs">Rizki Pratama &bull; 12345.rizki@kvt.1</p></div><span class="text-xs text-gray-600 bg-white/5 px-3 py-1 rounded-full font-mono">siswa</span></div>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mb-6"><div class="bg-white/5 rounded-xl p-4"><p class="text-2xl font-bold text-white">XII RPL 1</p><p class="text-gray-500 text-xs mt-1">Kelas</p></div><div class="bg-white/5 rounded-xl p-4"><p class="text-2xl font-bold text-green-400">87.5</p><p class="text-gray-500 text-xs mt-1">Rata-rata</p></div><div class="bg-white/5 rounded-xl p-4"><p class="text-2xl font-bold text-white">12</p><p class="text-gray-500 text-xs mt-1">Total Nilai</p></div></div>
                <div class="bg-white/5 rounded-xl p-4"><p class="text-gray-500 text-xs uppercase tracking-wider mb-3">Nilai Terakhir</p><div class="space-y-3"><div class="flex items-center justify-between"><div><p class="text-white text-sm">Pemrograman Web</p><p class="text-gray-600 text-[10px]">Bu Dewi &bull; Ganjil 2025/2026</p></div><div class="text-right"><span class="text-green-400 font-bold text-lg">92</span><span class="ml-2 bg-green-500/20 text-green-400 text-[10px] px-1.5 py-0.5 rounded">A</span></div></div><div class="flex items-center justify-between"><div><p class="text-white text-sm">Basis Data</p><p class="text-gray-600 text-[10px]">Pak Budi &bull; Ganjil 2025/2026</p></div><div class="text-right"><span class="text-blue-400 font-bold text-lg">85</span><span class="ml-2 bg-blue-500/20 text-blue-400 text-[10px] px-1.5 py-0.5 rounded">B</span></div></div></div></div>
            </div>
        </div>
    </div>
</section>

{{-- ==================== HOW IT WORKS ==================== --}}
<section id="how" class="py-32 relative overflow-hidden">
    <div class="absolute inset-0 parallax-layer" data-speed="0.15"><div class="glow-orb w-[600px] h-[600px] bg-white/[0.015] top-1/3 -right-64"></div></div>
    <div class="max-w-5xl mx-auto px-6 relative z-10">
        <div class="text-center mb-24">
            <p class="fade-in text-gray-500 text-sm uppercase tracking-[0.4em] mb-4 font-mono">// CARA KERJA</p>
            <h2 class="fade-in text-4xl md:text-6xl font-black text-white">Mulai dalam<br><span class="gradient-text">3 Langkah</span></h2>
        </div>
        <div class="relative">
            <div class="hidden md:block absolute left-16 top-0 bottom-0 w-px"><div class="w-full h-full bg-gradient-to-b from-white/30 via-white/10 to-transparent"></div></div>
            <div class="space-y-20">
                @php $steps = [
                    ['num' => '01', 'title' => 'Daftarkan Sekolah Anda', 'desc' => 'Isi form registrasi dengan data resmi sekolah: NPSN, nama sekolah, kota, dan provinsi. Sistem memvalidasi data dan menghasilkan School ID unik.', 'detail' => 'NPSN 8 digit &rarr; School Code kvt.1, kvt.2, dst', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5'],
                    ['num' => '02', 'title' => 'Akun Otomatis Dibuat', 'desc' => 'Setelah disetujui Admin KVT, sistem otomatis membuat akun Admin Sekolah dengan email @kvt.id dan lisensi Basic aktif selama 1 tahun.', 'detail' => 'Admin mendapat email: admin.sekolah@kvt.1', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                    ['num' => '03', 'title' => 'Kelola & Nilai KVT', 'desc' => 'Admin menambahkan guru & siswa (otomatis dapat email @kvt.id). Guru input nilai KVT per kompetensi, predikat dihitung otomatis A-E.', 'detail' => 'Siswa bisa lihat nilai & GPA real-time', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                ]; @endphp

                @foreach($steps as $step)
                <div class="slide-{{ $loop->even ? 'right' : 'left' }} flex items-start gap-8 md:gap-12 group">
                    <div class="flex-shrink-0 relative">
                        <div class="w-32 h-32 bg-zinc-950 border border-white/10 rounded-2xl flex flex-col items-center justify-center group-hover:border-white/20 transition-all duration-500">
                            <span class="text-5xl font-black text-white/[0.07] group-hover:text-white/15 transition-colors duration-500">{{ $step['num'] }}</span>
                            <svg class="w-6 h-6 text-gray-600 group-hover:text-white transition-colors duration-500 -mt-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $step['icon'] }}"/></svg>
                        </div>
                    </div>
                    <div class="pt-4 flex-1">
                        <h3 class="text-2xl md:text-3xl font-bold text-white mb-3">{{ $step['title'] }}</h3>
                        <p class="text-gray-400 leading-relaxed text-lg mb-4">{{ $step['desc'] }}</p>
                        <div class="inline-flex items-center gap-2 bg-white/5 rounded-xl px-4 py-2 border border-white/5">
                            <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-gray-300 text-sm">{!! $step['detail'] !!}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ==================== EMAIL SHOWCASE ==================== --}}
<section class="py-32 relative overflow-hidden">
    <div class="absolute inset-0 parallax-layer" data-speed="-0.05"><div class="glow-orb w-[600px] h-[600px] bg-purple-500/[0.02] bottom-0 left-1/4"></div></div>
    <div class="max-w-5xl mx-auto px-6 relative z-10">
        <div class="text-center mb-16">
            <p class="fade-in text-gray-500 text-sm uppercase tracking-[0.4em] mb-4 font-mono">// FORMAT EMAIL</p>
            <h2 class="fade-in text-4xl md:text-6xl font-black text-white mb-5">Email Resmi<br><span class="gradient-text">@kvt.id</span></h2>
            <p class="fade-in text-gray-500 text-lg">Setiap sekolah dan user mendapat email unik berdasarkan kode sekolah</p>
        </div>
        <div class="scale-in grid md:grid-cols-2 gap-6">
            <div class="bg-zinc-950/80 border border-white/5 rounded-2xl p-8 hover:border-white/10 transition-all">
                <p class="text-gray-500 text-xs uppercase tracking-wider mb-4 font-mono">Admin & Platform</p>
                <div class="space-y-3">
                    @foreach([['email'=>'universe.kvt@kvt.id','role'=>'Super Admin KVT','c'=>'purple','i'=>'U'],['email'=>'admin.smkn1@kvt.1','role'=>'Admin Sekolah - SMKN 1','c'=>'blue','i'=>'A'],['email'=>'admin.sman2@kvt.2','role'=>'Admin Sekolah - SMAN 2','c'=>'blue','i'=>'A']] as $ae)
                    <div class="bg-white/5 rounded-xl px-4 py-3 flex items-center gap-3 hover:bg-white/8 transition-colors">
                        <div class="w-8 h-8 bg-gradient-to-br from-{{ $ae['c'] }}-500/30 to-{{ $ae['c'] }}-600/30 rounded-full flex items-center justify-center text-xs font-bold text-{{ $ae['c'] }}-300">{{ $ae['i'] }}</div>
                        <div class="flex-1"><span class="text-white font-mono text-sm">{{ $ae['email'] }}</span><p class="text-gray-600 text-[10px]">{{ $ae['role'] }}</p></div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="bg-zinc-950/80 border border-white/5 rounded-2xl p-8 hover:border-white/10 transition-all">
                <p class="text-gray-500 text-xs uppercase tracking-wider mb-4 font-mono">Guru & Siswa</p>
                <div class="space-y-3">
                    @foreach([['email'=>'budi.santoso@kvt.1','role'=>'Guru - SMKN 1','c'=>'cyan','i'=>'G'],['email'=>'12345.rizki.pratama@kvt.1','role'=>'Siswa - NISN 12345','c'=>'green','i'=>'S'],['email'=>'67890.siti.aminah@kvt.2','role'=>'Siswa - NISN 67890','c'=>'green','i'=>'S']] as $ue)
                    <div class="bg-white/5 rounded-xl px-4 py-3 flex items-center gap-3 hover:bg-white/8 transition-colors">
                        <div class="w-8 h-8 bg-gradient-to-br from-{{ $ue['c'] }}-500/30 to-{{ $ue['c'] }}-600/30 rounded-full flex items-center justify-center text-xs font-bold text-{{ $ue['c'] }}-300">{{ $ue['i'] }}</div>
                        <div class="flex-1"><span class="text-white font-mono text-sm">{{ $ue['email'] }}</span><p class="text-gray-600 text-[10px]">{{ $ue['role'] }}</p></div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ==================== ROLE COMPARISON ==================== --}}
<section class="py-32 relative overflow-hidden">
    <div class="max-w-6xl mx-auto px-6 relative z-10">
        <div class="text-center mb-16">
            <p class="fade-in text-gray-500 text-sm uppercase tracking-[0.4em] mb-4 font-mono">// ROLE & AKSES</p>
            <h2 class="fade-in text-4xl md:text-6xl font-black text-white mb-5">4 Peran,<br><span class="gradient-text">4 Dashboard</span></h2>
            <p class="fade-in text-gray-500 text-lg">Setiap peran memiliki tampilan dan akses yang berbeda sesuai kebutuhan</p>
        </div>
        <div class="scale-in grid md:grid-cols-2 lg:grid-cols-4 gap-4">
            @php $roles = [
                ['name'=>'Admin KVT','emoji'=>'&#128081;','features'=>['Kelola seluruh sekolah','Approve/reject pendaftaran','CRUD lisensi','Lihat semua data','Activity log global']],
                ['name'=>'Admin Sekolah','emoji'=>'&#127979;','features'=>['Kelola guru & siswa','Kelola kelas','Lihat nilai sekolah','Profil sekolah','Lihat lisensi']],
                ['name'=>'Guru','emoji'=>'&#128218;','features'=>['Input nilai KVT','Lihat kelas diajar','CRUD nilai sendiri','Profil diri','Dashboard statistik']],
                ['name'=>'Siswa','emoji'=>'&#127891;','features'=>['Lihat nilai sendiri','Lihat kelas','Rata-rata otomatis','Profil diri','Dashboard akademik']],
            ]; @endphp
            @foreach($roles as $role)
            <div class="fade-in bg-zinc-950/80 border border-white/5 rounded-2xl p-6 hover:border-white/15 transition-all duration-500 group">
                <div class="text-4xl mb-4">{!! $role['emoji'] !!}</div>
                <h3 class="text-white font-bold text-lg mb-5 group-hover:translate-x-1 transition-transform">{{ $role['name'] }}</h3>
                <ul class="space-y-2.5">
                    @foreach($role['features'] as $feature)
                    <li class="flex items-center gap-2 text-gray-500 text-xs group-hover:text-gray-400 transition-colors">
                        <svg class="w-3.5 h-3.5 text-gray-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        {{ $feature }}
                    </li>
                    @endforeach
                </ul>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ==================== TESTIMONIALS ==================== --}}
<section id="testimonials" class="py-32 relative overflow-hidden">
    <div class="absolute inset-0 parallax-layer" data-speed="0.1"><div class="glow-orb w-[500px] h-[500px] bg-blue-500/[0.02] top-0 left-1/3"></div></div>
    <div class="max-w-6xl mx-auto px-6 relative z-10">
        <div class="text-center mb-16">
            <p class="fade-in text-gray-500 text-sm uppercase tracking-[0.4em] mb-4 font-mono">// TESTIMONI</p>
            <h2 class="fade-in text-4xl md:text-6xl font-black text-white mb-5">Apa Kata<br><span class="gradient-text">Mereka</span></h2>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            @php $testimonials = [
                ['name'=>'Budi Hartono','role'=>'Kepala Sekolah SMKN 1 Surabaya','text'=>'Universe KVT membantu kami mengelola penilaian vokasi dengan lebih terstruktur. Sistem email otomatis sangat memudahkan administrasi.','initial'=>'BH'],
                ['name'=>'Dewi Sartika','role'=>'Guru Produktif SMK','text'=>'Input nilai jadi sangat cepat dan rapi. Predikat otomatis A-E menghemat banyak waktu saya saat membuat laporan semester.','initial'=>'DS'],
                ['name'=>'Rizki Pratama','role'=>'Siswa XII RPL','text'=>'Saya bisa melihat nilai KVT saya kapan saja lewat dashboard. Tampilannya keren dan mudah dipahami. Login dengan GitHub juga mudah.','initial'=>'RP'],
            ]; @endphp
            @foreach($testimonials as $idx => $t)
            <div class="fade-in bg-zinc-950/80 border border-white/5 rounded-2xl p-8 hover:border-white/10 transition-all duration-500" style="transition-delay: {{ $idx * 100 }}ms;">
                <div class="flex items-center gap-1 mb-5">@for($i = 0; $i < 5; $i++)<svg class="w-4 h-4 text-yellow-400/80" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>@endfor</div>
                <p class="text-gray-400 text-sm leading-relaxed mb-6">"{{ $t['text'] }}"</p>
                <div class="flex items-center gap-3"><div class="w-10 h-10 bg-gradient-to-br from-gray-600 to-gray-800 rounded-full flex items-center justify-center text-sm font-bold text-white">{{ $t['initial'] }}</div><div><p class="text-white text-sm font-medium">{{ $t['name'] }}</p><p class="text-gray-600 text-xs">{{ $t['role'] }}</p></div></div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ==================== TECH STACK ==================== --}}
<section class="py-24 relative overflow-hidden">
    <div class="max-w-5xl mx-auto px-6">
        <div class="text-center mb-12">
            <p class="fade-in text-gray-500 text-sm uppercase tracking-[0.4em] mb-4 font-mono">// TECH STACK</p>
            <h2 class="fade-in text-3xl md:text-4xl font-black text-white">Dibangun dengan Teknologi Modern</h2>
        </div>
        <div class="fade-in flex flex-wrap justify-center gap-3">
            @foreach(['Laravel 12'=>'&#9889;','PHP 8.2+'=>'&#128013;','MySQL'=>'&#128450;','Tailwind CSS'=>'&#127912;','Alpine.js'=>'&#9968;','GSAP'=>'&#127916;','REST API'=>'&#128279;','OAuth 2.0'=>'&#128274;','Socialite'=>'&#128101;'] as $tech => $emoji)
            <span class="bg-zinc-950/80 border border-white/5 px-6 py-3 rounded-xl text-gray-400 text-sm hover:text-white hover:border-white/20 hover:bg-white/5 transition-all duration-300 cursor-default flex items-center gap-2"><span class="text-base">{!! $emoji !!}</span>{{ $tech }}</span>
            @endforeach
        </div>
    </div>
</section>

{{-- ==================== PRICING ==================== --}}
<section id="pricing" class="py-32 relative overflow-hidden">
    <div class="absolute inset-0 parallax-layer" data-speed="-0.08"><div class="glow-orb w-[600px] h-[600px] bg-white/[0.015] bottom-0 right-0"></div></div>
    <div class="max-w-6xl mx-auto px-6 relative z-10">
        <div class="text-center mb-16">
            <p class="fade-in text-gray-500 text-sm uppercase tracking-[0.4em] mb-4 font-mono">// LISENSI</p>
            <h2 class="fade-in text-4xl md:text-6xl font-black text-white mb-5">Pilih Paket<br><span class="gradient-text">Anda</span></h2>
            <p class="fade-in text-gray-500 text-lg">Semua paket termasuk email @kvt.id, penilaian KVT, dan activity log</p>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            @php $plans = [
                ['name'=>'Basic','price'=>'Gratis','guru'=>'10','siswa'=>'100','kelas'=>'5','highlight'=>false,'extras'=>['Dashboard standar','Email @kvt.id']],
                ['name'=>'Pro','price'=>'Rp 500K','period'=>'/tahun','guru'=>'50','siswa'=>'500','kelas'=>'20','highlight'=>true,'extras'=>['Priority support','API access','OAuth login']],
                ['name'=>'Premium','price'=>'Rp 1.5JT','period'=>'/tahun','guru'=>'200','siswa'=>'2.000','kelas'=>'100','highlight'=>false,'extras'=>['Dedicated support','Custom branding','White-label']],
            ]; @endphp
            @foreach($plans as $plan)
            <div class="scale-in card-hover rounded-2xl p-8 relative {{ $plan['highlight'] ? 'bg-white text-black border-2 border-white ring-4 ring-white/10 scale-[1.02]' : 'bg-zinc-950/80 text-white border border-white/5' }}">
                @if($plan['highlight'])<div class="absolute -top-3 left-1/2 -translate-x-1/2"><span class="bg-black text-white text-xs px-4 py-1.5 rounded-full font-bold shadow-lg animate-pulse">POPULER</span></div>@endif
                <h3 class="text-2xl font-bold mb-2">{{ $plan['name'] }}</h3>
                <div class="mb-6"><span class="text-4xl font-black">{{ $plan['price'] }}</span>@if(isset($plan['period']))<span class="text-gray-500 text-sm">{{ $plan['period'] }}</span>@endif</div>
                <ul class="space-y-3 mb-8">
                    @foreach([['Maks. '.$plan['guru'].' Guru'],['Maks. '.$plan['siswa'].' Siswa'],['Maks. '.$plan['kelas'].' Kelas'],['Penilaian KVT + Email @kvt.id']] as $item)
                    <li class="flex items-center gap-2 text-sm"><svg class="w-4 h-4 flex-shrink-0 {{ $plan['highlight'] ? 'text-black' : 'text-gray-500' }}" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>{{ $item[0] }}</li>
                    @endforeach
                    @foreach($plan['extras'] as $extra)
                    <li class="flex items-center gap-2 text-sm"><svg class="w-4 h-4 flex-shrink-0 {{ $plan['highlight'] ? 'text-black' : 'text-gray-500' }}" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>{{ $extra }}</li>
                    @endforeach
                </ul>
                <a href="{{ route('register') }}" class="{{ $plan['highlight'] ? 'bg-black text-white hover:bg-gray-900' : 'bg-white text-black hover:bg-gray-200' }} block text-center px-6 py-4 rounded-xl font-bold transition-all text-sm hover:scale-[1.02]">Mulai Sekarang</a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ==================== FAQ ==================== --}}
<section class="py-32 relative">
    <div class="max-w-3xl mx-auto px-6">
        <div class="text-center mb-16">
            <p class="fade-in text-gray-500 text-sm uppercase tracking-[0.4em] mb-4 font-mono">// FAQ</p>
            <h2 class="fade-in text-4xl md:text-5xl font-black text-white">Pertanyaan<br><span class="gradient-text">Umum</span></h2>
        </div>
        <div class="fade-in space-y-3" x-data="{ openFaq: null }">
            @php $faqs = [
                ['q'=>'Apa itu Universe KVT?','a'=>'Universe KVT adalah platform pendidikan berbasis Kompetensi Vokasi Terpadu (KVT) untuk mengelola sekolah, guru, siswa, dan penilaian kompetensi dalam satu ekosistem digital.'],
                ['q'=>'Bagaimana cara mendaftarkan sekolah?','a'=>'Klik "Daftar Sekolah", isi data sekolah (NPSN, nama, lokasi) dan data admin. Setelah disetujui Admin KVT, akun Anda akan aktif dengan email @kvt.id dan lisensi Basic.'],
                ['q'=>'Apakah bisa login dengan GitHub atau Google?','a'=>'Ya! Anda bisa login menggunakan akun GitHub atau Google. Pastikan email GitHub/Google Anda sudah terdaftar di sistem Universe KVT oleh admin sekolah Anda.'],
                ['q'=>'Apakah email @kvt.id bisa untuk kirim email?','a'=>'Saat ini email @kvt.id digunakan sebagai identitas login dan pengenal resmi user dalam platform. Fitur kirim/terima email akan tersedia di update mendatang.'],
                ['q'=>'Bagaimana sistem penilaian KVT bekerja?','a'=>'Guru menginput nilai per kompetensi (0-100). Sistem otomatis menghitung predikat: A (≥90), B (≥80), C (≥70), D (≥60), E (<60). Siswa bisa lihat nilai dan rata-rata di dashboard.'],
                ['q'=>'Apakah bisa upgrade lisensi?','a'=>'Ya, hubungi Admin KVT untuk upgrade lisensi dari Basic ke Pro atau Premium. Kuota guru, siswa, dan kelas akan disesuaikan.'],
            ]; @endphp
            @foreach($faqs as $idx => $faq)
            <div class="bg-zinc-950/80 border border-white/5 rounded-xl overflow-hidden hover:border-white/10 transition-all">
                <button @click="openFaq = openFaq === {{ $idx }} ? null : {{ $idx }}" class="w-full flex items-center justify-between px-6 py-5 text-left group">
                    <span class="text-white font-medium text-sm group-hover:translate-x-1 transition-transform">{{ $faq['q'] }}</span>
                    <svg class="w-5 h-5 text-gray-500 transition-transform duration-300 flex-shrink-0 ml-4" :class="openFaq === {{ $idx }} ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="openFaq === {{ $idx }}" x-transition x-cloak class="px-6 pb-5"><p class="text-gray-500 text-sm leading-relaxed">{{ $faq['a'] }}</p></div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ==================== CTA ==================== --}}
<section class="py-32 relative overflow-hidden">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <div class="fade-in relative">
            <div class="bg-gradient-to-br from-zinc-900 to-zinc-950 border border-white/10 rounded-3xl p-12 md:p-20 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-72 h-72 bg-white/[0.02] rounded-full blur-3xl float"></div>
                <div class="absolute bottom-0 left-0 w-56 h-56 bg-purple-500/[0.02] rounded-full blur-3xl float float-delay"></div>
                <div class="relative z-10">
                    <p class="text-gray-500 text-sm uppercase tracking-[0.3em] mb-6 font-mono">// JOIN US</p>
                    <h2 class="text-3xl md:text-6xl font-black text-white mb-5 leading-tight">Siap Bergabung?</h2>
                    <p class="text-gray-400 text-lg mb-12 max-w-xl mx-auto leading-relaxed">Daftarkan sekolah Anda sekarang dan dapatkan akses ke platform pendidikan KVT yang resmi dan terverifikasi.</p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <a href="{{ route('register') }}" class="bg-white text-black px-10 py-4 rounded-xl font-bold hover:bg-gray-200 transition-all text-base shadow-xl shadow-white/10 hover:scale-105 flex items-center gap-2">Daftarkan Sekolah <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg></a>
                        <a href="{{ route('login') }}" class="border border-gray-700 text-white px-10 py-4 rounded-xl font-semibold hover:border-white transition-all text-base hover:bg-white/5">Masuk</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ==================== FOOTER ==================== --}}
<footer class="border-t border-white/5 pt-16 pb-8 relative z-10">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-4 gap-10 mb-12">
            <div class="md:col-span-2">
                <div class="flex items-center gap-3 mb-4"><div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center"><span class="text-black font-black text-sm">KVT</span></div><span class="text-white font-bold text-xl">Universe <span class="text-gray-500 font-light">KVT</span></span></div>
                <p class="text-gray-600 text-sm leading-relaxed max-w-md mb-4">Platform pusat pendidikan berbasis Kompetensi Vokasi Terpadu. Mengelola sekolah, guru, siswa, dan penilaian dalam satu ekosistem digital.</p>
                <a href="https://github.com/kuro-myths/kvt-pendidikan" target="_blank" class="w-8 h-8 bg-white/5 rounded-lg flex items-center justify-center hover:bg-white/10 transition-colors inline-flex"><svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg></a>
            </div>
            <div>
                <h4 class="text-white font-bold text-sm mb-4">Navigasi</h4>
                <ul class="space-y-2"><li><a href="#features" class="text-gray-600 hover:text-white text-sm transition-colors">Fitur</a></li><li><a href="#preview" class="text-gray-600 hover:text-white text-sm transition-colors">Preview</a></li><li><a href="#pricing" class="text-gray-600 hover:text-white text-sm transition-colors">Lisensi</a></li><li><a href="{{ route('login') }}" class="text-gray-600 hover:text-white text-sm transition-colors">Masuk</a></li><li><a href="{{ route('register') }}" class="text-gray-600 hover:text-white text-sm transition-colors">Daftar</a></li></ul>
            </div>
            <div>
                <h4 class="text-white font-bold text-sm mb-4">Legal</h4>
                <ul class="space-y-2"><li><a href="#" class="text-gray-600 hover:text-white text-sm transition-colors">Ketentuan Layanan</a></li><li><a href="#" class="text-gray-600 hover:text-white text-sm transition-colors">Kebijakan Privasi</a></li><li><a href="#" class="text-gray-600 hover:text-white text-sm transition-colors">Lisensi</a></li><li><a href="https://github.com/kuro-myths/kvt-pendidikan" target="_blank" class="text-gray-600 hover:text-white text-sm transition-colors">GitHub</a></li></ul>
            </div>
        </div>
        <div class="border-t border-white/5 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <span class="text-gray-600 text-sm">Universe KVT &copy; {{ date('Y') }} &mdash; Platform Pendidikan Resmi.</span>
            <span class="text-gray-700 text-xs">Made with &#10084; for Indonesian Education</span>
        </div>
    </div>
</footer>
@endsection

@push('scripts')
<script>
    gsap.registerPlugin(ScrollTrigger);

    // Scroll Progress Bar
    gsap.to('#scrollProgress', { scaleX: 1, ease: 'none', scrollTrigger: { trigger: 'body', start: 'top top', end: 'bottom bottom', scrub: 0.3 } });
    gsap.set('#scrollProgress', { scaleX: 0 });

    // Particle Canvas
    (function() {
        const canvas = document.getElementById('particleCanvas');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        let particles = [];
        function resize() { canvas.width = window.innerWidth; canvas.height = window.innerHeight; }
        resize(); window.addEventListener('resize', resize);
        class Particle {
            constructor() { this.reset(); }
            reset() { this.x = Math.random() * canvas.width; this.y = Math.random() * canvas.height; this.size = Math.random() * 2 + 0.5; this.speedX = (Math.random() - 0.5) * 0.3; this.speedY = (Math.random() - 0.5) * 0.3; this.opacity = Math.random() * 0.5 + 0.1; }
            update() { this.x += this.speedX; this.y += this.speedY; if (this.x < 0 || this.x > canvas.width) this.speedX *= -1; if (this.y < 0 || this.y > canvas.height) this.speedY *= -1; }
            draw() { ctx.beginPath(); ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2); ctx.fillStyle = `rgba(255,255,255,${this.opacity})`; ctx.fill(); }
        }
        for (let i = 0; i < 60; i++) particles.push(new Particle());
        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            particles.forEach(p => { p.update(); p.draw(); });
            for (let i = 0; i < particles.length; i++) for (let j = i + 1; j < particles.length; j++) {
                const dx = particles[i].x - particles[j].x, dy = particles[i].y - particles[j].y, dist = Math.sqrt(dx*dx+dy*dy);
                if (dist < 150) { ctx.beginPath(); ctx.moveTo(particles[i].x, particles[i].y); ctx.lineTo(particles[j].x, particles[j].y); ctx.strokeStyle = `rgba(255,255,255,${0.03*(1-dist/150)})`; ctx.stroke(); }
            }
            requestAnimationFrame(animate);
        }
        animate();
    })();

    // Meteor Animations
    function animateMeteor(id, delay) {
        gsap.to(id, { x: -300, y: 300, opacity: 0, duration: 1.2, ease: 'power2.in', delay: delay,
            onStart: function() { gsap.set(id, { opacity: 0.6 }); },
            onComplete: function() { gsap.set(id, { x: 0, y: 0, opacity: 0 }); animateMeteor(id, Math.random() * 8 + 3); }
        });
    }
    animateMeteor('#meteor1', 2); animateMeteor('#meteor2', 5); animateMeteor('#meteor3', 9);

    // Parallax Layers
    document.querySelectorAll('.parallax-layer').forEach(layer => {
        const speed = parseFloat(layer.dataset.speed) || 0.1;
        gsap.to(layer, { yPercent: speed * 100, ease: 'none', scrollTrigger: { trigger: layer.parentElement, start: 'top bottom', end: 'bottom top', scrub: true } });
    });

    // Hero Animations
    const heroTl = gsap.timeline({ delay: 0.3 });
    heroTl.from('#heroLine1', { y: 80, opacity: 0, duration: 1, ease: 'power4.out' })
        .from('#heroLine2', { y: 80, opacity: 0, duration: 1, ease: 'power4.out' }, '-=0.6')
        .to('.hero-badge .fade-in', { opacity: 1, y: 0, duration: 0.8, ease: 'power3.out' }, '-=0.8')
        .to('.hero-desc', { opacity: 1, y: 0, duration: 0.8, ease: 'power3.out' }, '-=0.5')
        .to('.hero-buttons', { opacity: 1, y: 0, duration: 0.8, ease: 'power3.out' }, '-=0.5')
        .to('.hero-stats .fade-in', { opacity: 1, y: 0, duration: 0.8, ease: 'power3.out' }, '-=0.3');

    // Counter Animation
    document.querySelectorAll('.counter[data-target]').forEach(counter => {
        const target = parseInt(counter.dataset.target), suffix = counter.dataset.suffix || '';
        ScrollTrigger.create({ trigger: counter, start: 'top 85%', onEnter: () => {
            gsap.to({ val: 0 }, { val: target, duration: 2, ease: 'power2.out', onUpdate: function() {
                const val = Math.round(this.targets()[0].val);
                counter.textContent = val >= 1000 ? Math.round(val/1000) + 'K' + suffix : val + suffix;
            }});
        }, once: true });
    });

    // Scroll-triggered Animations
    gsap.utils.toArray('.fade-in').forEach(el => {
        if (el.closest('.hero-badge, .hero-desc, .hero-buttons, .hero-stats')) return;
        gsap.to(el, { opacity: 1, y: 0, duration: 1, ease: 'power3.out', scrollTrigger: { trigger: el, start: 'top 88%' } });
    });
    gsap.utils.toArray('.slide-left').forEach(el => { gsap.to(el, { opacity: 1, x: 0, duration: 1, ease: 'power3.out', scrollTrigger: { trigger: el, start: 'top 85%' } }); });
    gsap.utils.toArray('.slide-right').forEach(el => { gsap.to(el, { opacity: 1, x: 0, duration: 1, ease: 'power3.out', scrollTrigger: { trigger: el, start: 'top 85%' } }); });
    gsap.utils.toArray('.scale-in').forEach(el => { gsap.to(el, { opacity: 1, scale: 1, duration: 0.8, ease: 'back.out(1.5)', scrollTrigger: { trigger: el, start: 'top 85%' } }); });

    // Smooth Scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) { const t = document.querySelector(this.getAttribute('href')); if (t) { e.preventDefault(); t.scrollIntoView({ behavior: 'smooth', block: 'start' }); } });
    });
</script>
@endpush
