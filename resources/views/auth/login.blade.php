@extends('layouts.app')

@section('title', 'Masuk')

@section('content')
<div class="min-h-screen flex items-center justify-center px-6 relative overflow-hidden">
    {{-- Background --}}
    <div class="absolute inset-0">
        <div class="absolute top-1/3 left-1/3 w-96 h-96 bg-white/[0.015] rounded-full blur-3xl"></div>
    </div>

    <div class="w-full max-w-md relative z-10 fade-in">
        {{-- Logo --}}
        <div class="text-center mb-10">
            <a href="{{ route('landing') }}" class="inline-flex items-center gap-3 mb-6">
                <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center">
                    <span class="text-black font-black text-base">KVT</span>
                </div>
            </a>
            <h1 class="text-3xl font-black text-white mb-2">Masuk</h1>
            <p class="text-gray-500 text-sm">Masuk ke akun Universe KVT Anda</p>
        </div>

        {{-- Form --}}
        <div class="bg-zinc-950 border border-white/5 rounded-2xl p-8">
            <form action="{{ route('login.process') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Email KVT</label>
                    <input type="text" name="email" value="{{ old('email') }}" placeholder="contoh: username@kvt.1" required autofocus>
                    @error('email')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Password</label>
                    <div x-data="{ showPass: false }" class="relative">
                        <input :type="showPass ? 'text' : 'password'" name="password" placeholder="Masukkan password" required>
                        <button type="button" @click="showPass = !showPass" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-white">
                            <svg x-show="!showPass" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg x-show="showPass" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        </button>
                    </div>
                    @error('password')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="!w-4 !h-4 rounded !p-0">
                        <span class="text-gray-400 text-sm">Ingat saya</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-gray-500 hover:text-white text-sm transition-colors">Lupa Password?</a>
                </div>

                <button type="submit" class="w-full bg-white text-black font-bold py-3 px-6 rounded-xl hover:bg-gray-200 transition-all text-sm">
                    Masuk
                </button>
            </form>
        </div>

        <p class="text-center mt-6 text-gray-600 text-sm">
            Belum punya akun? <a href="{{ route('register') }}" class="text-white hover:underline font-medium">Daftar Sekolah</a>
        </p>

        <p class="text-center mt-3">
            <a href="{{ route('landing') }}" class="text-gray-600 hover:text-white text-sm transition-colors">&larr; Kembali ke Beranda</a>
        </p>
    </div>
</div>
@endsection

@push('scripts')
<script>
    gsap.from('.fade-in', { opacity: 0, y: 30, duration: 0.8, ease: 'power3.out' });
</script>
@endpush
