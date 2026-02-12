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
            <a href="#preview" class="text-gray-400 hover:text-white transition-colors text-sm">Preview</a>
            <a href="#how" class="text-gray-400 hover:text-white transition-colors text-sm">Cara Kerja</a>
            <a href="#testimonials" class="text-gray-400 hover:text-white transition-colors text-sm">Testimoni</a>
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
        <a href="#preview" class="block text-gray-400 hover:text-white text-sm py-2">Preview</a>
        <a href="#how" class="block text-gray-400 hover:text-white text-sm py-2">Cara Kerja</a>
        <a href="#pricing" class="block text-gray-400 hover:text-white text-sm py-2">Harga</a>
        <a href="{{ route('login') }}" class="block text-gray-400 hover:text-white text-sm py-2">Masuk</a>
        <a href="{{ route('register') }}" class="block bg-white text-black px-5 py-2.5 rounded-lg text-sm font-semibold text-center">Daftar Sekolah</a>
    </div>
</nav>

{{-- HERO SECTION --}}
<section class="min-h-screen flex items-center justify-center relative overflow-hidden pt-20">
    {{-- Animated background --}}
    <div class="absolute inset-0">
        <div class="absolute top-1/4 left-1/4 w-[500px] h-[500px] bg-white/[0.02] rounded-full blur-3xl animate-pulse" style="animation-duration: 4s;"></div>
        <div class="absolute bottom-1/4 right-1/4 w-[400px] h-[400px] bg-white/[0.015] rounded-full blur-3xl animate-pulse" style="animation-duration: 6s;"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-[radial-gradient(circle_at_center,rgba(255,255,255,0.03)_0%,transparent_70%)]"></div>
        {{-- Grid pattern --}}
        <div class="absolute inset-0 opacity-[0.03]" style="background-image: linear-gradient(rgba(255,255,255,.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.1) 1px, transparent 1px); background-size: 60px 60px;"></div>
    </div>

    <div class="max-w-6xl mx-auto px-6 text-center relative z-10">
        <div class="fade-in">
            <div class="inline-flex items-center gap-2 bg-white/5 border border-white/10 rounded-full px-5 py-2.5 mb-8">
                <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                <span class="text-gray-400 text-sm">Platform Pendidikan Resmi Berbasis KVT</span>
                <span class="bg-white/10 text-gray-300 text-xs px-2 py-0.5 rounded-full">v2.0</span>
            </div>
        </div>

        <h1 class="fade-in text-5xl md:text-7xl lg:text-8xl font-black leading-[0.9] mb-6 tracking-tight">
            <span class="gradient-text">Universe</span><br>
            <span class="text-white">KVT</span>
        </h1>

        <p class="fade-in text-gray-400 text-lg md:text-xl max-w-2xl mx-auto mb-10 leading-relaxed">
            Platform pusat pendidikan berbasis <span class="text-white font-medium">Kompetensi Vokasi Terpadu</span>.
            Kelola sekolah, guru, siswa, dan penilaian dalam satu ekosistem digital yang resmi dan terverifikasi.
        </p>

        <div class="fade-in flex flex-col sm:flex-row items-center justify-center gap-4 mb-16">
            <a href="{{ route('register') }}" class="group bg-white text-black px-8 py-4 rounded-xl text-base font-bold hover:bg-gray-200 transition-all hover:scale-105 flex items-center gap-2 shadow-lg shadow-white/5">
                Daftarkan Sekolah
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </a>
            <a href="{{ route('login') }}" class="border border-gray-700 text-white px-8 py-4 rounded-xl text-base font-semibold hover:border-white transition-all hover:bg-white/5">
                Masuk ke Akun
            </a>
        </div>

        {{-- Stats Bar --}}
        <div class="fade-in grid grid-cols-2 md:grid-cols-4 gap-6 max-w-3xl mx-auto">
            <div class="bg-zinc-950/80 border border-white/5 rounded-xl px-4 py-5">
                <p class="text-3xl font-black text-white">100+</p>
                <p class="text-xs text-gray-500 mt-1">Sekolah Terdaftar</p>
            </div>
            <div class="bg-zinc-950/80 border border-white/5 rounded-xl px-4 py-5">
                <p class="text-3xl font-black text-white">5K+</p>
                <p class="text-xs text-gray-500 mt-1">Siswa Aktif</p>
            </div>
            <div class="bg-zinc-950/80 border border-white/5 rounded-xl px-4 py-5">
                <p class="text-3xl font-black text-white">50K+</p>
                <p class="text-xs text-gray-500 mt-1">Nilai Tercatat</p>
            </div>
            <div class="bg-zinc-950/80 border border-white/5 rounded-xl px-4 py-5">
                <p class="text-3xl font-black text-white">@kvt.id</p>
                <p class="text-xs text-gray-500 mt-1">Email Resmi</p>
            </div>
        </div>
    </div>

    {{-- Scroll indicator --}}
    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 animate-bounce">
        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
    </div>
</section>

{{-- TRUSTED BY / PARTNER LOGOS --}}
<section class="py-16 border-y border-white/5">
    <div class="max-w-7xl mx-auto px-6">
        <p class="text-center text-gray-600 text-xs uppercase tracking-[0.3em] mb-10">Dipercaya oleh institusi pendidikan di seluruh Indonesia</p>
        <div class="flex flex-wrap items-center justify-center gap-10 md:gap-16 opacity-40">
            @foreach(['Kemendikbud', 'BSNP', 'BNSP', 'Dirjen SMK', 'LPTK'] as $partner)
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center">
                    <span class="text-white text-xs font-bold">{{ substr($partner, 0, 2) }}</span>
                </div>
                <span class="text-white text-sm font-medium">{{ $partner }}</span>
            </div>
            @endforeach
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
                ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>', 'title' => 'Registrasi Sekolah Otomatis', 'desc' => 'Sekolah mendaftar dengan NPSN, sistem otomatis membuat School ID, akun admin, dan ruang data khusus.', 'color' => 'blue'],
                ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>', 'title' => 'Email @kvt.id Otomatis', 'desc' => 'Setiap user mendapat email resmi format rizki@kvt.1, budi@kvt.2 berdasarkan kode sekolah.', 'color' => 'green'],
                ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>', 'title' => 'Penilaian KVT Lengkap', 'desc' => 'Input nilai per kompetensi, semester, dan tahun ajaran. Predikat otomatis A-E dengan analytics.', 'color' => 'yellow'],
                ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>', 'title' => 'Sistem Lisensi', 'desc' => 'Tiga tingkat lisensi: Basic, Pro, Premium dengan kuota dan masa berlaku yang jelas.', 'color' => 'purple'],
                ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>', 'title' => 'Role-Based Access', 'desc' => '4 peran: Admin KVT, Admin Sekolah, Guru, Siswa. Masing-masing dashboard dan akses terpisah.', 'color' => 'red'],
                ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>', 'title' => 'REST API', 'desc' => 'API terenkripsi berbasis School ID untuk integrasi dengan LMS atau sistem eksternal.', 'color' => 'cyan'],
                ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>', 'title' => 'Activity Log', 'desc' => 'Semua aktivitas tercatat lengkap: login, perubahan data, hapus, dengan IP dan timestamp.', 'color' => 'orange'],
                ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>', 'title' => 'Profil & Password', 'desc' => 'Setiap user bisa mengatur profil dan mengubah password dengan aman.', 'color' => 'pink'],
                ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>', 'title' => 'Responsive Design', 'desc' => 'Tampilan optimal di desktop, tablet, dan smartphone. Dark mode elegant dengan animasi halus.', 'color' => 'teal'],
            ];
            @endphp

            @foreach($features as $f)
            <div class="fade-in card-hover bg-zinc-950 border border-white/5 rounded-2xl p-8 group relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-{{ $f['color'] }}-500/5 rounded-full blur-2xl -translate-y-1/2 translate-x-1/2 group-hover:bg-{{ $f['color'] }}-500/10 transition-all duration-500"></div>
                <div class="relative">
                    <div class="w-12 h-12 bg-white/5 rounded-xl flex items-center justify-center mb-5 group-hover:bg-white/10 transition-colors">
                        <svg class="w-6 h-6 text-gray-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $f['icon'] !!}</svg>
                    </div>
                    <h3 class="text-white font-bold text-lg mb-2">{{ $f['title'] }}</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">{{ $f['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- DASHBOARD PREVIEW SECTION --}}
<section id="preview" class="py-32 bg-zinc-950/50 relative overflow-hidden">
    <div class="absolute inset-0 opacity-[0.02]" style="background-image: linear-gradient(rgba(255,255,255,.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,.1) 1px, transparent 1px); background-size: 40px 40px;"></div>

    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="text-center mb-16">
            <p class="fade-in text-gray-500 text-sm uppercase tracking-[0.3em] mb-3">DASHBOARD PREVIEW</p>
            <h2 class="fade-in text-4xl md:text-5xl font-black text-white mb-4">Intuitif & Powerful</h2>
            <p class="fade-in text-gray-500 max-w-xl mx-auto">Dashboard yang dirancang khusus untuk setiap peran pengguna</p>
        </div>

        {{-- Dashboard Mockup --}}
        <div class="scale-in" x-data="{ activeTab: 'admin_kvt' }">
            {{-- Tab selector --}}
            <div class="flex flex-wrap justify-center gap-2 mb-8">
                <button @click="activeTab = 'admin_kvt'" :class="activeTab === 'admin_kvt' ? 'bg-white text-black' : 'bg-white/5 text-gray-400 hover:text-white'" class="px-5 py-2.5 rounded-lg text-sm font-semibold transition-all">Admin KVT</button>
                <button @click="activeTab = 'admin_sekolah'" :class="activeTab === 'admin_sekolah' ? 'bg-white text-black' : 'bg-white/5 text-gray-400 hover:text-white'" class="px-5 py-2.5 rounded-lg text-sm font-semibold transition-all">Admin Sekolah</button>
                <button @click="activeTab = 'guru'" :class="activeTab === 'guru' ? 'bg-white text-black' : 'bg-white/5 text-gray-400 hover:text-white'" class="px-5 py-2.5 rounded-lg text-sm font-semibold transition-all">Guru</button>
                <button @click="activeTab = 'siswa'" :class="activeTab === 'siswa' ? 'bg-white text-black' : 'bg-white/5 text-gray-400 hover:text-white'" class="px-5 py-2.5 rounded-lg text-sm font-semibold transition-all">Siswa</button>
            </div>

            {{-- Admin KVT Dashboard Mock --}}
            <div x-show="activeTab === 'admin_kvt'" x-transition class="bg-zinc-950 border border-white/10 rounded-2xl overflow-hidden shadow-2xl shadow-black/50">
                <div class="flex">
                    {{-- Sidebar mock --}}
                    <div class="hidden md:block w-56 bg-zinc-950 border-r border-white/5 p-4 space-y-2">
                        <div class="flex items-center gap-2 px-3 py-2">
                            <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center"><span class="text-black font-black text-xs">KVT</span></div>
                            <span class="text-white font-bold text-sm">Universe</span>
                        </div>
                        <div class="mt-4 space-y-1">
                            <div class="px-3 py-2 bg-white/10 rounded-lg text-white text-xs flex items-center gap-2"><span class="w-1.5 h-1.5 bg-white rounded-full"></span> Dashboard</div>
                            <div class="px-3 py-2 text-gray-500 text-xs">Kelola Sekolah</div>
                            <div class="px-3 py-2 text-gray-500 text-xs">Lisensi</div>
                            <div class="px-3 py-2 text-gray-500 text-xs">Semua User</div>
                            <div class="px-3 py-2 text-gray-500 text-xs">Activity Log</div>
                        </div>
                    </div>
                    {{-- Main content --}}
                    <div class="flex-1 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-white font-bold text-lg">Dashboard Admin KVT</h3>
                                <p class="text-gray-500 text-xs">Ringkasan seluruh platform</p>
                            </div>
                            <span class="text-xs text-gray-600 bg-white/5 px-3 py-1 rounded-full">Admin KVT</span>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
                            <div class="bg-white/5 rounded-xl p-4"><p class="text-2xl font-bold text-white">127</p><p class="text-gray-500 text-xs mt-1">Sekolah</p></div>
                            <div class="bg-white/5 rounded-xl p-4"><p class="text-2xl font-bold text-green-400">98</p><p class="text-gray-500 text-xs mt-1">Aktif</p></div>
                            <div class="bg-white/5 rounded-xl p-4"><p class="text-2xl font-bold text-yellow-400">12</p><p class="text-gray-500 text-xs mt-1">Pending</p></div>
                            <div class="bg-white/5 rounded-xl p-4"><p class="text-2xl font-bold text-white">5,243</p><p class="text-gray-500 text-xs mt-1">Total User</p></div>
                        </div>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="bg-white/5 rounded-xl p-4">
                                <p class="text-gray-500 text-xs uppercase tracking-wider mb-3">Sekolah Pending</p>
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between"><span class="text-white text-xs">SMK Negeri 3 Bandung</span><span class="bg-yellow-500/20 text-yellow-400 text-[10px] px-2 py-0.5 rounded-full">Pending</span></div>
                                    <div class="flex items-center justify-between"><span class="text-white text-xs">SMA IT Al-Ikhlas</span><span class="bg-yellow-500/20 text-yellow-400 text-[10px] px-2 py-0.5 rounded-full">Pending</span></div>
                                    <div class="flex items-center justify-between"><span class="text-white text-xs">SMK Muhammadiyah 1</span><span class="bg-yellow-500/20 text-yellow-400 text-[10px] px-2 py-0.5 rounded-full">Pending</span></div>
                                </div>
                            </div>
                            <div class="bg-white/5 rounded-xl p-4">
                                <p class="text-gray-500 text-xs uppercase tracking-wider mb-3">Aktivitas Terbaru</p>
                                <div class="space-y-2">
                                    <div class="flex items-center gap-2"><span class="bg-green-500/20 text-green-400 text-[10px] px-2 py-0.5 rounded-full">login</span><span class="text-gray-400 text-xs">Admin SMKN1 login</span></div>
                                    <div class="flex items-center gap-2"><span class="bg-blue-500/20 text-blue-400 text-[10px] px-2 py-0.5 rounded-full">create</span><span class="text-gray-400 text-xs">User baru ditambahkan</span></div>
                                    <div class="flex items-center gap-2"><span class="bg-yellow-500/20 text-yellow-400 text-[10px] px-2 py-0.5 rounded-full">update</span><span class="text-gray-400 text-xs">Nilai diperbarui</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Admin Sekolah Dashboard Mock --}}
            <div x-show="activeTab === 'admin_sekolah'" x-transition class="bg-zinc-950 border border-white/10 rounded-2xl overflow-hidden shadow-2xl shadow-black/50 p-6 md:p-8">
                <div class="flex items-center justify-between mb-6">
                    <div><h3 class="text-white font-bold text-lg">Dashboard Admin Sekolah</h3><p class="text-gray-500 text-xs">SMKN 1 Surabaya &bull; kvt.1</p></div>
                    <span class="text-xs text-gray-600 bg-white/5 px-3 py-1 rounded-full">Admin Sekolah</span>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
                    <div class="bg-white/5 rounded-xl p-4"><p class="text-2xl font-bold text-white">24</p><p class="text-gray-500 text-xs mt-1">Guru</p></div>
                    <div class="bg-white/5 rounded-xl p-4"><p class="text-2xl font-bold text-white">487</p><p class="text-gray-500 text-xs mt-1">Siswa</p></div>
                    <div class="bg-white/5 rounded-xl p-4"><p class="text-2xl font-bold text-white">18</p><p class="text-gray-500 text-xs mt-1">Kelas</p></div>
                    <div class="bg-green-500/10 rounded-xl p-4"><div class="flex items-center gap-1"><p class="text-lg font-bold text-green-400">Pro</p><span class="text-green-400 text-[10px]">Aktif</span></div><p class="text-gray-500 text-xs mt-1">Lisensi</p></div>
                </div>
                <div class="bg-white/5 rounded-xl p-4">
                    <p class="text-gray-500 text-xs uppercase tracking-wider mb-3">Siswa Terbaru</p>
                    <div class="space-y-2">
                        <div class="flex items-center gap-3"><div class="w-6 h-6 bg-green-500/20 rounded-full flex items-center justify-center text-[10px] font-bold text-green-400">R</div><span class="text-white text-xs">Rizki Pratama</span><span class="text-gray-600 text-[10px] font-mono ml-auto">12345.rizki@kvt.1</span></div>
                        <div class="flex items-center gap-3"><div class="w-6 h-6 bg-green-500/20 rounded-full flex items-center justify-center text-[10px] font-bold text-green-400">S</div><span class="text-white text-xs">Siti Nurhaliza</span><span class="text-gray-600 text-[10px] font-mono ml-auto">67890.siti@kvt.1</span></div>
                    </div>
                </div>
            </div>

            {{-- Guru Dashboard Mock --}}
            <div x-show="activeTab === 'guru'" x-transition class="bg-zinc-950 border border-white/10 rounded-2xl overflow-hidden shadow-2xl shadow-black/50 p-6 md:p-8">
                <div class="flex items-center justify-between mb-6">
                    <div><h3 class="text-white font-bold text-lg">Dashboard Guru</h3><p class="text-gray-500 text-xs">Budi Santoso &bull; budi.santoso@kvt.1</p></div>
                    <span class="text-xs text-gray-600 bg-white/5 px-3 py-1 rounded-full">Guru</span>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mb-6">
                    <div class="bg-white/5 rounded-xl p-4"><p class="text-2xl font-bold text-white">3</p><p class="text-gray-500 text-xs mt-1">Kelas Diajar</p></div>
                    <div class="bg-white/5 rounded-xl p-4"><p class="text-2xl font-bold text-white">156</p><p class="text-gray-500 text-xs mt-1">Nilai Tercatat</p></div>
                    <div class="bg-white/5 rounded-xl p-4"><p class="text-2xl font-bold text-white">89</p><p class="text-gray-500 text-xs mt-1">Siswa</p></div>
                </div>
                <div class="bg-white/5 rounded-xl p-4">
                    <p class="text-gray-500 text-xs uppercase tracking-wider mb-3">Nilai Terbaru</p>
                    <div class="overflow-x-auto">
                        <table class="w-full text-xs">
                            <thead><tr class="text-gray-600"><th class="text-left py-2">Siswa</th><th class="text-left py-2">Kompetensi</th><th class="text-right py-2">Nilai</th><th class="text-right py-2">Predikat</th></tr></thead>
                            <tbody class="text-gray-300">
                                <tr><td class="py-1.5">Rizki Pratama</td><td>Pemrograman Web</td><td class="text-right font-bold text-green-400">92</td><td class="text-right"><span class="bg-green-500/20 text-green-400 text-[10px] px-1.5 py-0.5 rounded">A</span></td></tr>
                                <tr><td class="py-1.5">Siti Aminah</td><td>Database</td><td class="text-right font-bold text-blue-400">85</td><td class="text-right"><span class="bg-blue-500/20 text-blue-400 text-[10px] px-1.5 py-0.5 rounded">B</span></td></tr>
                                <tr><td class="py-1.5">Ahmad Fauzi</td><td>Jaringan</td><td class="text-right font-bold text-yellow-400">73</td><td class="text-right"><span class="bg-yellow-500/20 text-yellow-400 text-[10px] px-1.5 py-0.5 rounded">C</span></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Siswa Dashboard Mock --}}
            <div x-show="activeTab === 'siswa'" x-transition class="bg-zinc-950 border border-white/10 rounded-2xl overflow-hidden shadow-2xl shadow-black/50 p-6 md:p-8">
                <div class="flex items-center justify-between mb-6">
                    <div><h3 class="text-white font-bold text-lg">Dashboard Siswa</h3><p class="text-gray-500 text-xs">Rizki Pratama &bull; 12345.rizki@kvt.1</p></div>
                    <span class="text-xs text-gray-600 bg-white/5 px-3 py-1 rounded-full">Siswa</span>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mb-6">
                    <div class="bg-white/5 rounded-xl p-4"><p class="text-2xl font-bold text-white">XII RPL 1</p><p class="text-gray-500 text-xs mt-1">Kelas</p></div>
                    <div class="bg-white/5 rounded-xl p-4"><p class="text-2xl font-bold text-green-400">87.5</p><p class="text-gray-500 text-xs mt-1">Rata-rata</p></div>
                    <div class="bg-white/5 rounded-xl p-4"><p class="text-2xl font-bold text-white">12</p><p class="text-gray-500 text-xs mt-1">Total Nilai</p></div>
                </div>
                <div class="bg-white/5 rounded-xl p-4">
                    <p class="text-gray-500 text-xs uppercase tracking-wider mb-3">Nilai Terakhir</p>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <div><p class="text-white text-sm">Pemrograman Web</p><p class="text-gray-600 text-[10px]">Bu Dewi &bull; Ganjil 2025/2026</p></div>
                            <div class="text-right"><span class="text-green-400 font-bold text-lg">92</span><span class="ml-2 bg-green-500/20 text-green-400 text-[10px] px-1.5 py-0.5 rounded">A</span></div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div><p class="text-white text-sm">Basis Data</p><p class="text-gray-600 text-[10px]">Pak Budi &bull; Ganjil 2025/2026</p></div>
                            <div class="text-right"><span class="text-blue-400 font-bold text-lg">85</span><span class="ml-2 bg-blue-500/20 text-blue-400 text-[10px] px-1.5 py-0.5 rounded">B</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- HOW IT WORKS --}}
<section id="how" class="py-32">
    <div class="max-w-5xl mx-auto px-6">
        <div class="text-center mb-20">
            <p class="fade-in text-gray-500 text-sm uppercase tracking-[0.3em] mb-3">CARA KERJA</p>
            <h2 class="fade-in text-4xl md:text-5xl font-black text-white">Mulai dalam 3 Langkah</h2>
        </div>

        <div class="relative">
            {{-- Vertical line --}}
            <div class="hidden md:block absolute left-[60px] top-0 bottom-0 w-px bg-gradient-to-b from-white/20 via-white/10 to-transparent"></div>

            <div class="space-y-16">
                @php
                $steps = [
                    ['num' => '01', 'title' => 'Daftarkan Sekolah Anda', 'desc' => 'Isi form registrasi dengan data resmi sekolah: NPSN, nama sekolah, kota, provinsi, dan kontak. Sistem akan memvalidasi data dan menghasilkan School ID unik.', 'detail' => 'NPSN 8 digit &#8594; School Code kvt.1, kvt.2, dst'],
                    ['num' => '02', 'title' => 'Akun Otomatis Dibuat', 'desc' => 'Setelah disetujui Admin KVT, sistem otomatis membuat akun Admin Sekolah dengan email @kvt.id dan lisensi Basic aktif selama 1 tahun.', 'detail' => 'Admin mendapat email: admin.sekolah@kvt.1'],
                    ['num' => '03', 'title' => 'Kelola & Nilai KVT', 'desc' => 'Admin sekolah menambahkan guru & siswa (otomatis dapat email @kvt.id). Guru input nilai KVT per kompetensi, predikat dihitung otomatis A-E.', 'detail' => 'Siswa bisa lihat nilai & GPA real-time'],
                ];
                @endphp

                @foreach($steps as $step)
                <div class="slide-{{ $loop->even ? 'right' : 'left' }} flex items-start gap-8">
                    <div class="flex-shrink-0 relative">
                        <div class="w-[120px] h-[120px] bg-zinc-950 border border-white/10 rounded-2xl flex items-center justify-center">
                            <span class="text-5xl font-black text-white/10">{{ $step['num'] }}</span>
                        </div>
                    </div>
                    <div class="pt-2">
                        <h3 class="text-2xl font-bold text-white mb-3">{{ $step['title'] }}</h3>
                        <p class="text-gray-500 leading-relaxed text-lg mb-3">{{ $step['desc'] }}</p>
                        <div class="inline-flex items-center gap-2 bg-white/5 rounded-lg px-3 py-1.5">
                            <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-gray-400 text-sm">{!! $step['detail'] !!}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- EMAIL SHOWCASE --}}
<section class="py-32 bg-zinc-950/50">
    <div class="max-w-5xl mx-auto px-6">
        <div class="text-center mb-16">
            <p class="fade-in text-gray-500 text-sm uppercase tracking-[0.3em] mb-3">FORMAT EMAIL</p>
            <h2 class="fade-in text-4xl md:text-5xl font-black text-white mb-4">Email Resmi @kvt.id</h2>
            <p class="fade-in text-gray-500">Setiap sekolah dan user mendapat email unik berdasarkan kode sekolah</p>
        </div>

        <div class="scale-in grid md:grid-cols-2 gap-6">
            <div class="bg-zinc-950 border border-white/5 rounded-2xl p-8">
                <p class="text-gray-500 text-xs uppercase tracking-wider mb-4">Contoh Akun Admin & Platform</p>
                <div class="space-y-3">
                    <div class="bg-white/5 rounded-lg px-4 py-3 flex items-center gap-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-purple-500/30 to-purple-600/30 rounded-full flex items-center justify-center text-xs font-bold text-purple-300">U</div>
                        <div class="flex-1"><span class="text-white font-mono text-sm">universe.kvt@kvt.id</span><p class="text-gray-600 text-[10px]">Super Admin KVT</p></div>
                    </div>
                    <div class="bg-white/5 rounded-lg px-4 py-3 flex items-center gap-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500/30 to-blue-600/30 rounded-full flex items-center justify-center text-xs font-bold text-blue-300">A</div>
                        <div class="flex-1"><span class="text-white font-mono text-sm">admin.smkn1@kvt.1</span><p class="text-gray-600 text-[10px]">Admin Sekolah - SMKN 1</p></div>
                    </div>
                    <div class="bg-white/5 rounded-lg px-4 py-3 flex items-center gap-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500/30 to-blue-600/30 rounded-full flex items-center justify-center text-xs font-bold text-blue-300">A</div>
                        <div class="flex-1"><span class="text-white font-mono text-sm">admin.sman2@kvt.2</span><p class="text-gray-600 text-[10px]">Admin Sekolah - SMAN 2</p></div>
                    </div>
                </div>
            </div>
            <div class="bg-zinc-950 border border-white/5 rounded-2xl p-8">
                <p class="text-gray-500 text-xs uppercase tracking-wider mb-4">Contoh Akun Guru & Siswa</p>
                <div class="space-y-3">
                    <div class="bg-white/5 rounded-lg px-4 py-3 flex items-center gap-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-cyan-500/30 to-cyan-600/30 rounded-full flex items-center justify-center text-xs font-bold text-cyan-300">G</div>
                        <div class="flex-1"><span class="text-white font-mono text-sm">budi.santoso@kvt.1</span><p class="text-gray-600 text-[10px]">Guru - SMKN 1</p></div>
                    </div>
                    <div class="bg-white/5 rounded-lg px-4 py-3 flex items-center gap-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-green-500/30 to-green-600/30 rounded-full flex items-center justify-center text-xs font-bold text-green-300">S</div>
                        <div class="flex-1"><span class="text-white font-mono text-sm">12345.rizki.pratama@kvt.1</span><p class="text-gray-600 text-[10px]">Siswa - NISN 12345</p></div>
                    </div>
                    <div class="bg-white/5 rounded-lg px-4 py-3 flex items-center gap-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-green-500/30 to-green-600/30 rounded-full flex items-center justify-center text-xs font-bold text-green-300">S</div>
                        <div class="flex-1"><span class="text-white font-mono text-sm">67890.siti.aminah@kvt.2</span><p class="text-gray-600 text-[10px]">Siswa - NISN 67890</p></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ROLE COMPARISON --}}
<section class="py-32">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-16">
            <p class="fade-in text-gray-500 text-sm uppercase tracking-[0.3em] mb-3">ROLE & AKSES</p>
            <h2 class="fade-in text-4xl md:text-5xl font-black text-white mb-4">4 Peran, 4 Dashboard</h2>
            <p class="fade-in text-gray-500">Setiap peran memiliki tampilan dan akses yang berbeda sesuai kebutuhan</p>
        </div>

        <div class="scale-in grid md:grid-cols-2 lg:grid-cols-4 gap-4">
            @php
            $roles = [
                ['name' => 'Admin KVT', 'icon' => '&#9733;', 'color' => 'purple', 'features' => ['Kelola seluruh sekolah', 'Approve/reject pendaftaran', 'CRUD lisensi', 'Lihat semua data', 'Activity log global']],
                ['name' => 'Admin Sekolah', 'icon' => '&#9998;', 'color' => 'blue', 'features' => ['Kelola guru & siswa', 'Kelola kelas', 'Lihat nilai sekolah', 'Profil sekolah', 'Lihat lisensi']],
                ['name' => 'Guru', 'icon' => '&#9997;', 'color' => 'green', 'features' => ['Input nilai KVT', 'Lihat kelas diajar', 'CRUD nilai sendiri', 'Profil diri', 'Dashboard statistik']],
                ['name' => 'Siswa', 'icon' => '&#9733;', 'color' => 'orange', 'features' => ['Lihat nilai sendiri', 'Lihat kelas', 'Rata-rata otomatis', 'Profil diri', 'Dashboard akademik']],
            ];
            @endphp

            @foreach($roles as $role)
            <div class="bg-zinc-950 border border-white/5 rounded-2xl p-6 hover:border-{{ $role['color'] }}-500/30 transition-all duration-300 group">
                <div class="text-3xl mb-3">{!! $role['icon'] !!}</div>
                <h3 class="text-white font-bold text-lg mb-4">{{ $role['name'] }}</h3>
                <ul class="space-y-2">
                    @foreach($role['features'] as $feature)
                    <li class="flex items-center gap-2 text-gray-500 text-xs">
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

{{-- TESTIMONIALS --}}
<section id="testimonials" class="py-32 bg-zinc-950/50">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-16">
            <p class="fade-in text-gray-500 text-sm uppercase tracking-[0.3em] mb-3">TESTIMONI</p>
            <h2 class="fade-in text-4xl md:text-5xl font-black text-white mb-4">Apa Kata Mereka</h2>
        </div>

        <div class="scale-in grid md:grid-cols-3 gap-6">
            @php
            $testimonials = [
                ['name' => 'Budi Hartono', 'role' => 'Kepala Sekolah SMKN 1 Surabaya', 'text' => 'Universe KVT membantu kami mengelola penilaian vokasi dengan lebih terstruktur. Sistem email otomatis sangat memudahkan administrasi.', 'initial' => 'BH'],
                ['name' => 'Dewi Sartika', 'role' => 'Guru Produktif SMK', 'text' => 'Input nilai jadi sangat cepat dan rapi. Predikat otomatis A-E menghemat banyak waktu saya saat membuat laporan semester.', 'initial' => 'DS'],
                ['name' => 'Rizki Pratama', 'role' => 'Siswa XII RPL', 'text' => 'Saya bisa melihat nilai KVT saya kapan saja lewat dashboard. Tampilannya keren dan mudah dipahami.', 'initial' => 'RP'],
            ];
            @endphp

            @foreach($testimonials as $t)
            <div class="bg-zinc-950 border border-white/5 rounded-2xl p-8">
                <div class="flex items-center gap-1 mb-4">
                    @for($i = 0; $i < 5; $i++)
                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
                <p class="text-gray-400 text-sm leading-relaxed mb-6">"{{ $t['text'] }}"</p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-gray-600 to-gray-800 rounded-full flex items-center justify-center text-sm font-bold text-white">{{ $t['initial'] }}</div>
                    <div>
                        <p class="text-white text-sm font-medium">{{ $t['name'] }}</p>
                        <p class="text-gray-600 text-xs">{{ $t['role'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- TECH STACK --}}
<section class="py-20">
    <div class="max-w-5xl mx-auto px-6">
        <div class="text-center mb-12">
            <p class="fade-in text-gray-500 text-sm uppercase tracking-[0.3em] mb-3">TEKNOLOGI</p>
            <h2 class="fade-in text-3xl font-black text-white">Dibangun dengan Teknologi Modern</h2>
        </div>
        <div class="fade-in flex flex-wrap justify-center gap-4">
            @foreach(['Laravel 12', 'PHP 8.2+', 'MySQL', 'Tailwind CSS', 'Alpine.js', 'GSAP', 'REST API'] as $tech)
            <span class="bg-zinc-950 border border-white/5 px-5 py-2.5 rounded-xl text-gray-400 text-sm hover:text-white hover:border-white/20 transition-all">{{ $tech }}</span>
            @endforeach
        </div>
    </div>
</section>

{{-- PRICING / LICENSE --}}
<section id="pricing" class="py-32 bg-zinc-950/50">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-16">
            <p class="fade-in text-gray-500 text-sm uppercase tracking-[0.3em] mb-3">LISENSI</p>
            <h2 class="fade-in text-4xl md:text-5xl font-black text-white mb-4">Pilih Paket Anda</h2>
            <p class="fade-in text-gray-500">Semua paket termasuk email @kvt.id, penilaian KVT, dan activity log</p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            @php
            $plans = [
                ['name' => 'Basic', 'price' => 'Gratis', 'guru' => '10', 'siswa' => '100', 'kelas' => '5', 'highlight' => false, 'extras' => ['Dashboard standar', 'Email @kvt.id']],
                ['name' => 'Pro', 'price' => 'Rp 500K', 'period' => '/tahun', 'guru' => '50', 'siswa' => '500', 'kelas' => '20', 'highlight' => true, 'extras' => ['Priority support', 'API access']],
                ['name' => 'Premium', 'price' => 'Rp 1.5JT', 'period' => '/tahun', 'guru' => '200', 'siswa' => '2.000', 'kelas' => '100', 'highlight' => false, 'extras' => ['Dedicated support', 'Custom branding']],
            ];
            @endphp

            @foreach($plans as $plan)
            <div class="scale-in card-hover rounded-2xl p-8 relative {{ $plan['highlight'] ? 'bg-white text-black border-2 border-white ring-4 ring-white/10' : 'bg-zinc-950 text-white border border-white/5' }}">
                @if($plan['highlight'])
                <div class="absolute -top-3 left-1/2 -translate-x-1/2">
                    <span class="bg-black text-white text-xs px-4 py-1.5 rounded-full font-bold shadow-lg">POPULER</span>
                </div>
                @endif
                <h3 class="text-2xl font-bold mb-2">{{ $plan['name'] }}</h3>
                <div class="mb-6">
                    <span class="text-3xl font-black">{{ $plan['price'] }}</span>
                    @if(isset($plan['period']))
                    <span class="{{ $plan['highlight'] ? 'text-gray-500' : 'text-gray-500' }} text-sm">{{ $plan['period'] }}</span>
                    @endif
                </div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4 flex-shrink-0 {{ $plan['highlight'] ? 'text-black' : 'text-gray-500' }}" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        Maks. {{ $plan['guru'] }} Guru
                    </li>
                    <li class="flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4 flex-shrink-0 {{ $plan['highlight'] ? 'text-black' : 'text-gray-500' }}" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        Maks. {{ $plan['siswa'] }} Siswa
                    </li>
                    <li class="flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4 flex-shrink-0 {{ $plan['highlight'] ? 'text-black' : 'text-gray-500' }}" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        Maks. {{ $plan['kelas'] }} Kelas
                    </li>
                    <li class="flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4 flex-shrink-0 {{ $plan['highlight'] ? 'text-black' : 'text-gray-500' }}" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        Penilaian KVT + Email @kvt.id
                    </li>
                    @foreach($plan['extras'] as $extra)
                    <li class="flex items-center gap-2 text-sm">
                        <svg class="w-4 h-4 flex-shrink-0 {{ $plan['highlight'] ? 'text-black' : 'text-gray-500' }}" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        {{ $extra }}
                    </li>
                    @endforeach
                </ul>
                <a href="{{ route('register') }}" class="{{ $plan['highlight'] ? 'bg-black text-white hover:bg-gray-900' : 'bg-white text-black hover:bg-gray-200' }} block text-center px-6 py-3.5 rounded-xl font-bold transition-all text-sm">
                    Mulai Sekarang
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- FAQ --}}
<section class="py-32">
    <div class="max-w-3xl mx-auto px-6">
        <div class="text-center mb-16">
            <p class="fade-in text-gray-500 text-sm uppercase tracking-[0.3em] mb-3">FAQ</p>
            <h2 class="fade-in text-4xl font-black text-white">Pertanyaan Umum</h2>
        </div>

        <div class="fade-in space-y-3" x-data="{ openFaq: null }">
            @php
            $faqs = [
                ['q' => 'Apa itu Universe KVT?', 'a' => 'Universe KVT adalah platform pendidikan berbasis Kompetensi Vokasi Terpadu (KVT) untuk mengelola sekolah, guru, siswa, dan penilaian kompetensi dalam satu ekosistem digital yang terintegrasi.'],
                ['q' => 'Bagaimana cara mendaftarkan sekolah?', 'a' => 'Klik tombol "Daftar Sekolah", isi data sekolah (NPSN, nama, lokasi) dan data admin. Setelah disetujui Admin KVT, akun Anda akan aktif dengan email @kvt.id dan lisensi Basic.'],
                ['q' => 'Apakah email @kvt.id bisa digunakan untuk kirim email?', 'a' => 'Saat ini email @kvt.id digunakan sebagai identitas login dan pengenal resmi user dalam platform. Fitur kirim/terima email akan tersedia di update mendatang.'],
                ['q' => 'Bagaimana sistem penilaian KVT bekerja?', 'a' => 'Guru menginput nilai per kompetensi (0-100). Sistem otomatis menghitung predikat: A (≥90), B (≥80), C (≥70), D (≥60), E (<60). Siswa bisa melihat nilai dan rata-rata di dashboard.'],
                ['q' => 'Apakah bisa upgrade lisensi?', 'a' => 'Ya, hubungi Admin KVT untuk upgrade lisensi dari Basic ke Pro atau Premium. Kuota guru, siswa, dan kelas akan disesuaikan.'],
            ];
            @endphp

            @foreach($faqs as $idx => $faq)
            <div class="bg-zinc-950 border border-white/5 rounded-xl overflow-hidden">
                <button @click="openFaq = openFaq === {{ $idx }} ? null : {{ $idx }}" class="w-full flex items-center justify-between px-6 py-4 text-left">
                    <span class="text-white font-medium text-sm">{{ $faq['q'] }}</span>
                    <svg class="w-5 h-5 text-gray-500 transition-transform" :class="openFaq === {{ $idx }} ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="openFaq === {{ $idx }}" x-transition x-cloak class="px-6 pb-4">
                    <p class="text-gray-500 text-sm leading-relaxed">{{ $faq['a'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA SECTION --}}
<section class="py-32 bg-zinc-950/50">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <div class="fade-in bg-gradient-to-br from-zinc-900 to-zinc-950 border border-white/10 rounded-3xl p-12 md:p-20 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/[0.02] rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/[0.02] rounded-full blur-3xl"></div>
            <div class="relative z-10">
                <h2 class="text-3xl md:text-5xl font-black text-white mb-4">Siap Bergabung?</h2>
                <p class="text-gray-500 text-lg mb-10 max-w-xl mx-auto">Daftarkan sekolah Anda sekarang dan dapatkan akses ke platform pendidikan KVT yang resmi dan terverifikasi.</p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('register') }}" class="bg-white text-black px-8 py-4 rounded-xl font-bold hover:bg-gray-200 transition-all text-base shadow-lg shadow-white/5">Daftarkan Sekolah</a>
                    <a href="{{ route('login') }}" class="border border-gray-700 text-white px-8 py-4 rounded-xl font-semibold hover:border-white transition-all text-base">Masuk</a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- FOOTER --}}
<footer class="border-t border-white/5 pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-4 gap-10 mb-12">
            <div class="md:col-span-2">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center">
                        <span class="text-black font-black text-sm">KVT</span>
                    </div>
                    <span class="text-white font-bold text-xl">Universe <span class="text-gray-500 font-light">KVT</span></span>
                </div>
                <p class="text-gray-600 text-sm leading-relaxed max-w-md">Platform pusat pendidikan berbasis Kompetensi Vokasi Terpadu. Mengelola sekolah, guru, siswa, dan penilaian dalam satu ekosistem digital.</p>
            </div>
            <div>
                <h4 class="text-white font-bold text-sm mb-4">Navigasi</h4>
                <ul class="space-y-2">
                    <li><a href="#features" class="text-gray-600 hover:text-white text-sm transition-colors">Fitur</a></li>
                    <li><a href="#preview" class="text-gray-600 hover:text-white text-sm transition-colors">Preview</a></li>
                    <li><a href="#pricing" class="text-gray-600 hover:text-white text-sm transition-colors">Lisensi</a></li>
                    <li><a href="{{ route('login') }}" class="text-gray-600 hover:text-white text-sm transition-colors">Masuk</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-bold text-sm mb-4">Legal</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-600 hover:text-white text-sm transition-colors">Ketentuan Layanan</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-white text-sm transition-colors">Kebijakan Privasi</a></li>
                    <li><a href="#" class="text-gray-600 hover:text-white text-sm transition-colors">Lisensi</a></li>
                    <li><a href="https://github.com/kuro-myths/kvt-pendidikan" target="_blank" class="text-gray-600 hover:text-white text-sm transition-colors">GitHub</a></li>
                </ul>
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
