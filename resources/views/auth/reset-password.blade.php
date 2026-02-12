@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="min-h-screen flex items-center justify-center px-6 relative overflow-hidden">
    <div class="absolute inset-0">
        <div class="absolute top-1/3 left-1/3 w-96 h-96 bg-white/[0.015] rounded-full blur-3xl"></div>
    </div>

    <div class="w-full max-w-md relative z-10 fade-in">
        <div class="text-center mb-10">
            <a href="{{ route('landing') }}" class="inline-flex items-center gap-3 mb-6">
                <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center">
                    <span class="text-black font-black text-base">KVT</span>
                </div>
            </a>
            <h1 class="text-3xl font-black text-white mb-2">Reset Password</h1>
            <p class="text-gray-500 text-sm">Masukkan password baru Anda</p>
        </div>

        <div class="bg-zinc-950 border border-white/5 rounded-2xl p-8">
            <form action="{{ route('password.update') }}" method="POST" class="space-y-5">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Email KVT</label>
                    <input type="text" name="email" value="{{ old('email') }}" placeholder="contoh: username@kvt.1" required>
                    @error('email')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Password Baru</label>
                    <input type="password" name="password" placeholder="Minimal 8 karakter" required>
                    @error('password')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" placeholder="Ulangi password" required>
                </div>

                <button type="submit" class="w-full bg-white text-black font-bold py-3 px-6 rounded-xl hover:bg-gray-200 transition-all text-sm">
                    Reset Password
                </button>
            </form>
        </div>

        <p class="text-center mt-6">
            <a href="{{ route('login') }}" class="text-gray-600 hover:text-white text-sm transition-colors">&larr; Kembali ke Login</a>
        </p>
    </div>
</div>
@endsection

@push('scripts')
<script>
    gsap.to('.fade-in', { opacity: 1, y: 0, duration: 0.8, ease: 'power3.out' });
</script>
@endpush
