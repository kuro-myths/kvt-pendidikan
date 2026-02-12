@extends('layouts.app')

@section('title', 'Universe KVT')

@section('content')
{{-- NAVBAR --}}
<nav class="fixed top-0 w-full z-50 bg-black/60 backdrop-blur-xl border-b border-white/5" x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <a href="{{ route('landing') }}" class="flex items-center gap-3">
            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center">
                <span class="text-black font-black text-sm">KVT</span>
            </div>
            <span class="text-white font-bold text-xl">Universe <span class="text-gray-500 font-light">KVT</span></span>
        </a>
        <div class="hidden md:flex items-center gap-8">
            <a href="#features" class="text-gray-400 hover:text-white transition-colors text-sm">Fitur</a>
            <a href="#how" class="text-gray-400 hover:text-white transition-colors text-sm">Cara Kerja</a>
            <a href="#pricing" class="text-gray-400 hover:text-white transition-colors text-sm">Lisensi</a>
            <a href="{{ route('login') }}" class="text-gray-400 hover:text-white transition-colors text-sm">Masuk</a>
            <a href="{{ route('register') }}" class="bg-white text-black px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-200 transition-all">Daftar Sekolah</a>
        </div>
        <button @click="open = !open" class="md:hidden text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
    </div>
    <div x-show="open" x-transition class="md:hidden border-t border-white/5 bg-black/95 px-6 py-4 space-y-3">
        <a href="#features" class="block text-gray-400 hover:text-white text-sm py-2">Fitur</a>
        <a href="#how" class="block text-gray-400 hover:text-white text-sm py-2">Cara Kerja</a>
        <a href="{{ route('login') }}" class="block text-gray-400 hover:text-white text-sm py-2">Masuk</a>
        <a href="{{ route('register') }}" class="block bg-white text-black px-5 py-2.5 rounded-lg text-sm font-semibold text-center">Daftar Sekolah</a>
    </div>
</nav>

{{-- HERO SECTION --}}
<section class="min-h-screen flex items-center justify-center relative overflow-hidden pt-20">
    {{-- Background decorations --}}
    <div class="absolute inset-0">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-white/[0.02] rounded-full blur-3xl"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-white/[0.02] rounded-full blur-3xl"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(255,255,255,0.03)_0%,transparent_70%)]"></div>
    </div>

    <div class="max-w-5xl mx-auto px-6 text-center relative z-10">
        <div class="fade-in">
            <div class="inline-flex items-center gap-2 bg-white/5 border border-white/10 rounded-full px-4 py-2 mb-8">
                <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                <span class="text-gray-400 text-sm">Platform Pendidikan Resmi Berbasis KVT</span>
            </div>
        </div>

        <h1 class="fade-in text-5xl md:text-7xl lg:text-8xl font-black leading-tight mb-6">
            <span class="gradient-text">Universe</span><br>
            <span class="text-white">KVT</span>
        </h1>

        <p class="fade-in text-gray-400 text-lg md:text-xl max-w-2xl mx-auto mb-10 leading-relaxed">
            Platform pusat pendidikan berbasis Kompetensi Vokasi Terpadu.
            Kelola sekolah, guru, siswa, dan penilaian dalam satu ekosistem digital yang resmi dan terverifikasi.
        </p>

        <div class="fade-in flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('register') }}" class="bg-white text-black px-8 py-4 rounded-xl text-base font-bold hover:bg-gray-200 transition-all hover:scale-105 flex items-center gap-2">
                Daftarkan Sekolah
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </a>
            <a href="{{ route('login') }}" class="border border-gray-700 text-white px-8 py-4 rounded-xl text-base font-semibold hover:border-white transition-all">
                Masuk ke Akun
            </a>
        </div>

        {{-- Stats --}}
        <div class="fade-in mt-20 grid grid-cols-3 gap-8 max-w-lg mx-auto">
            <div>
                <p class="text-3xl font-bold text-white">100+</p>
                <p class="text-xs text-gray-500 mt-1">Sekolah</p>
            </div>
            <div>
                <p class="text-3xl font-bold text-white">5K+</p>
                <p class="text-xs text-gray-500 mt-1">Siswa</p>
            </div>
            <div>
                <p class="text-3xl font-bold text-white">@kvt.id</p>
                <p class="text-xs text-gray-500 mt-1">Email Resmi</p>
            </div>
        </div>
    </div>
</section>

{{-- FEATURES SECTION --}}
<section id="features" class="py-32 relative">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-20">
            <p class="fade-in text-gray-500 text-sm uppercase tracking-[0.3em] mb-3">FITUR PLATFORM</p>
            <h2 class="fade-in text-4xl md:text-5xl font-black text-white mb-4">Semua yang Anda<br>Butuhkan</h2>
            <p class="fade-in text-gray-500 max-w-xl mx-auto">Sistem lengkap untuk mengelola pendidikan KVT dari pendaftaran sampai penilaian.</p>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
            $features = [
                ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>', 'title' => 'Registrasi Sekolah Otomatis', 'desc' => 'Sekolah mendaftar dengan NPSN, sistem otomatis membuat School ID, akun admin, dan ruang data khusus.'],
                ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>', 'title' => 'Email @kvt.id Otomatis', 'desc' => 'Setiap user mendapat email resmi format rizki@kvt.1, budi@kvt.2 berdasarkan kode sekolah.'],
                ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>', 'title' => 'Penilaian KVT Lengkap', 'desc' => 'CRUD nilai per kompetensi, semester, dan tahun ajaran. Predikat otomatis A-E.'],
                ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>', 'title' => 'Sistem Lisensi KVT', 'desc' => 'Tiga tingkat lisensi: Basic, Pro, Premium dengan masa berlaku dan kuota yang jelas.'],
                ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>', 'title' => 'Role-Based Access', 'desc' => '4 peran: Admin KVT, Admin Sekolah, Guru, dan Siswa. Masing-masing dengan dashboard dan akses berbeda.'],
                ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>', 'title' => 'API Sinkronisasi', 'desc' => 'API berbasis School ID untuk integrasi dengan LMS atau sistem eksternal di masa depan.'],
            ];
            @endphp

            @foreach($features as $f)
            <div class="fade-in card-hover bg-zinc-950 border border-white/5 rounded-2xl p-8 group">
                <div class="w-12 h-12 bg-white/5 rounded-xl flex items-center justify-center mb-5 group-hover:bg-white/10 transition-colors">
                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $f['icon'] !!}</svg>
                </div>
                <h3 class="text-white font-bold text-lg mb-2">{{ $f['title'] }}</h3>
                <p class="text-gray-500 text-sm leading-relaxed">{{ $f['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- HOW IT WORKS --}}
<section id="how" class="py-32 bg-zinc-950/50">
    <div class="max-w-5xl mx-auto px-6">
        <div class="text-center mb-20">
            <p class="fade-in text-gray-500 text-sm uppercase tracking-[0.3em] mb-3">CARA KERJA</p>
            <h2 class="fade-in text-4xl md:text-5xl font-black text-white">Mulai dalam 3 Langkah</h2>
        </div>

        <div class="space-y-16">
            @php
            $steps = [
                ['num' => '01', 'title' => 'Daftarkan Sekolah Anda', 'desc' => 'Isi form registrasi dengan data resmi sekolah: NPSN, nama sekolah, kota, provinsi, dan kontak. Sistem akan memvalidasi data Anda.'],
                ['num' => '02', 'title' => 'Akun Otomatis Dibuat', 'desc' => 'Setelah disetujui, sistem otomatis membuat School ID (kvt.1, kvt.2...), akun Admin Sekolah dengan email @kvt.id, dan lisensi Basic.'],
                ['num' => '03', 'title' => 'Kelola Data & Nilai KVT', 'desc' => 'Admin sekolah menambahkan guru & siswa yang otomatis mendapat email @kvt.id. Guru bisa langsung input nilai KVT per kompetensi.'],
            ];
            @endphp

            @foreach($steps as $step)
            <div class="slide-{{ $loop->even ? 'right' : 'left' }} flex items-start gap-8">
                <div class="flex-shrink-0">
                    <span class="text-6xl font-black text-white/10">{{ $step['num'] }}</span>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-white mb-3">{{ $step['title'] }}</h3>
                    <p class="text-gray-500 leading-relaxed text-lg">{{ $step['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- EMAIL SHOWCASE --}}
<section class="py-32">
    <div class="max-w-5xl mx-auto px-6">
        <div class="text-center mb-16">
            <p class="fade-in text-gray-500 text-sm uppercase tracking-[0.3em] mb-3">FORMAT EMAIL</p>
            <h2 class="fade-in text-4xl md:text-5xl font-black text-white mb-4">Email Resmi @kvt.id</h2>
            <p class="fade-in text-gray-500">Setiap sekolah dan user mendapat email unik berdasarkan kode sekolah</p>
        </div>

        <div class="scale-in grid md:grid-cols-2 gap-6">
            <div class="bg-zinc-950 border border-white/5 rounded-2xl p-8">
                <p class="text-gray-500 text-xs uppercase tracking-wider mb-4">Contoh Akun Admin</p>
                <div class="space-y-3">
                    <div class="bg-white/5 rounded-lg px-4 py-3 flex items-center gap-3">
                        <div class="w-8 h-8 bg-white/10 rounded-full flex items-center justify-center text-xs font-bold">U</div>
                        <span class="text-white font-mono text-sm">universe.kvt@kvt.id</span>
                    </div>
                    <div class="bg-white/5 rounded-lg px-4 py-3 flex items-center gap-3">
                        <div class="w-8 h-8 bg-white/10 rounded-full flex items-center justify-center text-xs font-bold">A</div>
                        <span class="text-white font-mono text-sm">admin.sma1@kvt.1</span>
                    </div>
                    <div class="bg-white/5 rounded-lg px-4 py-3 flex items-center gap-3">
                        <div class="w-8 h-8 bg-white/10 rounded-full flex items-center justify-center text-xs font-bold">A</div>
                        <span class="text-white font-mono text-sm">admin.smk2@kvt.2</span>
                    </div>
                </div>
            </div>
            <div class="bg-zinc-950 border border-white/5 rounded-2xl p-8">
                <p class="text-gray-500 text-xs uppercase tracking-wider mb-4">Contoh Akun Guru & Siswa</p>
                <div class="space-y-3">
                    <div class="bg-white/5 rounded-lg px-4 py-3 flex items-center gap-3">
                        <div class="w-8 h-8 bg-blue-500/20 rounded-full flex items-center justify-center text-xs font-bold text-blue-400">G</div>
                        <span class="text-white font-mono text-sm">budi.santoso@kvt.1</span>
                    </div>
                    <div class="bg-white/5 rounded-lg px-4 py-3 flex items-center gap-3">
                        <div class="w-8 h-8 bg-green-500/20 rounded-full flex items-center justify-center text-xs font-bold text-green-400">S</div>
                        <span class="text-white font-mono text-sm">12345.rizki.habibi@kvt.1</span>
                    </div>
                    <div class="bg-white/5 rounded-lg px-4 py-3 flex items-center gap-3">
                        <div class="w-8 h-8 bg-green-500/20 rounded-full flex items-center justify-center text-xs font-bold text-green-400">S</div>
                        <span class="text-white font-mono text-sm">67890.siti.aminah@kvt.2</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- PRICING / LICENSE --}}
<section id="pricing" class="py-32 bg-zinc-950/50">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-16">
            <p class="fade-in text-gray-500 text-sm uppercase tracking-[0.3em] mb-3">LISENSI</p>
            <h2 class="fade-in text-4xl md:text-5xl font-black text-white mb-4">Pilih Paket Anda</h2>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            @php
            $plans = [
                ['name' => 'Basic', 'guru' => '10', 'siswa' => '100', 'kelas' => '5', 'highlight' => false],
                ['name' => 'Pro', 'guru' => '50', 'siswa' => '500', 'kelas' => '20', 'highlight' => true],
                ['name' => 'Premium', 'guru' => '200', 'siswa' => '2.000', 'kelas' => '100', 'highlight' => false],
            ];
            @endphp

            @foreach($plans as $plan)
            <div class="scale-in card-hover rounded-2xl p-8 {{ $plan['highlight'] ? 'bg-white text-black border-2 border-white' : 'bg-zinc-950 text-white border border-white/5' }}">
                @if($plan['highlight'])
                <span class="inline-block bg-black text-white text-xs px-3 py-1 rounded-full font-semibold mb-4">POPULER</span>
                @endif
                <h3 class="text-2xl font-bold mb-6">{{ $plan['name'] }}</h3>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4 {{ $plan['highlight'] ? 'text-black' : 'text-gray-500' }}" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        Maks. {{ $plan['guru'] }} Guru
                    </li>
                    <li class="flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4 {{ $plan['highlight'] ? 'text-black' : 'text-gray-500' }}" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        Maks. {{ $plan['siswa'] }} Siswa
                    </li>
                    <li class="flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4 {{ $plan['highlight'] ? 'text-black' : 'text-gray-500' }}" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        Maks. {{ $plan['kelas'] }} Kelas
                    </li>
                    <li class="flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4 {{ $plan['highlight'] ? 'text-black' : 'text-gray-500' }}" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        Email @kvt.id
                    </li>
                    <li class="flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4 {{ $plan['highlight'] ? 'text-black' : 'text-gray-500' }}" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        Penilaian KVT
                    </li>
                </ul>
                <a href="{{ route('register') }}" class="{{ $plan['highlight'] ? 'bg-black text-white hover:bg-gray-900' : 'bg-white text-black hover:bg-gray-200' }} block text-center px-6 py-3 rounded-xl font-semibold transition-all text-sm">
                    Mulai Sekarang
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA SECTION --}}
<section class="py-32">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <div class="fade-in bg-zinc-950 border border-white/5 rounded-3xl p-12 md:p-20">
            <h2 class="text-3xl md:text-5xl font-black text-white mb-4">Siap Bergabung?</h2>
            <p class="text-gray-500 text-lg mb-10 max-w-xl mx-auto">Daftarkan sekolah Anda sekarang dan dapatkan akses ke platform pendidikan KVT yang resmi dan terverifikasi.</p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('register') }}" class="bg-white text-black px-8 py-4 rounded-xl font-bold hover:bg-gray-200 transition-all text-base">Daftarkan Sekolah</a>
                <a href="{{ route('login') }}" class="border border-gray-700 text-white px-8 py-4 rounded-xl font-semibold hover:border-white transition-all text-base">Masuk</a>
            </div>
        </div>
    </div>
</section>

{{-- FOOTER --}}
<footer class="border-t border-white/5 py-16">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                    <span class="text-black font-black text-xs">KVT</span>
                </div>
                <span class="text-gray-500 text-sm">Universe KVT &copy; {{ date('Y') }}. Platform Pendidikan Resmi.</span>
            </div>
            <div class="flex items-center gap-6">
                <a href="#" class="text-gray-600 hover:text-white text-sm transition-colors">Ketentuan</a>
                <a href="#" class="text-gray-600 hover:text-white text-sm transition-colors">Privasi</a>
                <a href="#" class="text-gray-600 hover:text-white text-sm transition-colors">Kontak</a>
            </div>
        </div>
    </div>
</footer>
@endsection

@push('scripts')
<script>
    gsap.registerPlugin(ScrollTrigger);

    // Fade in animations
    gsap.utils.toArray('.fade-in').forEach(el => {
        gsap.to(el, {
            opacity: 1, y: 0, duration: 1, ease: 'power3.out',
            scrollTrigger: { trigger: el, start: 'top 85%', toggleActions: 'play none none none' }
        });
    });

    // Slide animations
    gsap.utils.toArray('.slide-left').forEach(el => {
        gsap.to(el, {
            opacity: 1, x: 0, duration: 1, ease: 'power3.out',
            scrollTrigger: { trigger: el, start: 'top 85%' }
        });
    });

    gsap.utils.toArray('.slide-right').forEach(el => {
        gsap.to(el, {
            opacity: 1, x: 0, duration: 1, ease: 'power3.out',
            scrollTrigger: { trigger: el, start: 'top 85%' }
        });
    });

    // Scale animations
    gsap.utils.toArray('.scale-in').forEach(el => {
        gsap.to(el, {
            opacity: 1, scale: 1, duration: 0.8, ease: 'back.out(1.5)',
            scrollTrigger: { trigger: el, start: 'top 85%' }
        });
    });
</script>
@endpush
