@extends('layouts.app')

@section('title', 'Daftar Sekolah')

@section('content')
<div class="min-h-screen flex items-center justify-center px-6 py-20 relative overflow-hidden">
    <div class="absolute inset-0">
        <div class="absolute top-1/3 right-1/3 w-96 h-96 bg-white/[0.015] rounded-full blur-3xl"></div>
    </div>

    <div class="w-full max-w-2xl relative z-10 fade-in">
        {{-- Logo --}}
        <div class="text-center mb-10">
            <a href="{{ route('landing') }}" class="inline-flex items-center gap-3 mb-6">
                <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center">
                    <span class="text-black font-black text-base">KVT</span>
                </div>
            </a>
            <h1 class="text-3xl font-black text-white mb-2">Daftar Sekolah</h1>
            <p class="text-gray-500 text-sm">Daftarkan sekolah Anda ke platform Universe KVT</p>
        </div>

        {{-- Form --}}
        <div class="bg-zinc-950 border border-white/5 rounded-2xl p-8">
            <form action="{{ route('register.process') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Data Sekolah --}}
                <div>
                    <h3 class="text-white font-bold text-lg mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        Data Sekolah
                    </h3>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1.5">NPSN <span class="text-red-400">*</span></label>
                            <input type="text" name="npsn" value="{{ old('npsn') }}" placeholder="8 digit NPSN" maxlength="8" required>
                            @error('npsn')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1.5">Jenjang <span class="text-red-400">*</span></label>
                            <select name="jenjang" required>
                                <option value="">Pilih Jenjang</option>
                                @foreach(['SD', 'SMP', 'SMA', 'SMK', 'MA', 'Lainnya'] as $j)
                                <option value="{{ $j }}" {{ old('jenjang') == $j ? 'selected' : '' }}>{{ $j }}</option>
                                @endforeach
                            </select>
                            @error('jenjang')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-400 mb-1.5">Nama Sekolah <span class="text-red-400">*</span></label>
                            <input type="text" name="nama_sekolah" value="{{ old('nama_sekolah') }}" placeholder="Contoh: SMA Negeri 1 Jakarta" required>
                            @error('nama_sekolah')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1.5">Kota/Kabupaten <span class="text-red-400">*</span></label>
                            <input type="text" name="kota" value="{{ old('kota') }}" placeholder="Contoh: Jakarta Selatan" required>
                            @error('kota')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1.5">Provinsi <span class="text-red-400">*</span></label>
                            <input type="text" name="provinsi" value="{{ old('provinsi') }}" placeholder="Contoh: DKI Jakarta" required>
                            @error('provinsi')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1.5">Telepon</label>
                            <input type="text" name="telepon" value="{{ old('telepon') }}" placeholder="Nomor telepon sekolah">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1.5">Kepala Sekolah</label>
                            <input type="text" name="kepala_sekolah" value="{{ old('kepala_sekolah') }}" placeholder="Nama kepala sekolah">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-400 mb-1.5">Alamat</label>
                            <textarea name="alamat" rows="2" placeholder="Alamat lengkap sekolah">{{ old('alamat') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="border-t border-white/5"></div>

                {{-- Data Admin --}}
                <div>
                    <h3 class="text-white font-bold text-lg mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Data Admin Sekolah
                    </h3>
                    <p class="text-gray-600 text-xs mb-4">Email @kvt.id akan dibuat otomatis berdasarkan nama admin Anda.</p>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-400 mb-1.5">Nama Admin <span class="text-red-400">*</span></label>
                            <input type="text" name="nama_admin" value="{{ old('nama_admin') }}" placeholder="Nama lengkap admin sekolah" required>
                            @error('nama_admin')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1.5">Password <span class="text-red-400">*</span></label>
                            <input type="password" name="password" placeholder="Minimal 8 karakter" required>
                            @error('password')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1.5">Konfirmasi Password <span class="text-red-400">*</span></label>
                            <input type="password" name="password_confirmation" placeholder="Ulangi password" required>
                        </div>
                    </div>
                </div>

                <div class="bg-white/5 rounded-xl p-4">
                    <p class="text-gray-400 text-xs">
                        <strong class="text-white">Catatan:</strong> Setelah registrasi, akun admin akan dibuat otomatis dengan email format <span class="text-white font-mono">namaanda@kvt.X</span>. Akun akan aktif setelah disetujui oleh Admin KVT.
                    </p>
                </div>

                <button type="submit" class="w-full bg-white text-black font-bold py-3.5 px-6 rounded-xl hover:bg-gray-200 transition-all text-sm">
                    Daftarkan Sekolah
                </button>
            </form>
        </div>

        <p class="text-center mt-6 text-gray-600 text-sm">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-white hover:underline font-medium">Masuk</a>
        </p>

        <p class="text-center mt-3">
            <a href="{{ route('landing') }}" class="text-gray-600 hover:text-white text-sm transition-colors">&larr; Kembali ke Beranda</a>
        </p>
    </div>
</div>
@endsection

@push('scripts')
<script>
    gsap.to('.fade-in', { opacity: 1, y: 0, duration: 0.8, ease: 'power3.out' });
</script>
@endpush
