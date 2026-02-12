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

            {{-- Divider --}}
            <div class="flex items-center gap-3 my-6">
                <div class="flex-1 h-px bg-white/10"></div>
                <span class="text-gray-600 text-xs uppercase tracking-wider">atau masuk dengan</span>
                <div class="flex-1 h-px bg-white/10"></div>
            </div>

            {{-- Social Login Buttons --}}
            <div class="flex gap-3">
                <a href="{{ route('social.redirect', 'github') }}" class="flex-1 flex items-center justify-center gap-2 bg-[#24292e] hover:bg-[#2f363d] text-white py-3 px-4 rounded-xl transition-all text-sm font-medium">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                    GitHub
                </a>
                <a href="{{ route('social.redirect', 'google') }}" class="flex-1 flex items-center justify-center gap-2 bg-white/5 hover:bg-white/10 border border-white/10 text-white py-3 px-4 rounded-xl transition-all text-sm font-medium">
                    <svg class="w-5 h-5" viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 0 1-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                    Google
                </a>
            </div>
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
    gsap.to('.fade-in', { opacity: 1, y: 0, duration: 0.8, ease: 'power3.out' });
</script>
@endpush
