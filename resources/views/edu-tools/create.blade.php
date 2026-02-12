@extends('layouts.dashboard')

@section('title', 'Tambah Edu Tool — Admin')
@section('page-title', 'Tambah Edu Tool')
@section('page-subtitle', 'Tambah tool edukasi baru ke katalog')

@section('content')
<div class="max-w-3xl mx-auto">
    <a href="{{ route('admin.edu-tools.index') }}" class="inline-flex items-center gap-2 text-gray-400 hover:text-white text-sm transition-colors mb-6">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali
    </a>

    <form action="{{ route('admin.edu-tools.store') }}" method="POST" class="bg-zinc-900/60 border border-white/5 rounded-xl p-6 space-y-5">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1">Nama Tool *</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="contoh: GitHub Education">
                @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1">Slug *</label>
                <input type="text" name="slug" value="{{ old('slug') }}" required placeholder="contoh: github-education">
                @error('slug') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-400 mb-1">Deskripsi Singkat *</label>
            <input type="text" name="short_description" value="{{ old('short_description') }}" required placeholder="Maks 500 karakter">
            @error('short_description') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-400 mb-1">Deskripsi Lengkap *</label>
            <textarea name="description" rows="4" required>{{ old('description') }}</textarea>
            @error('description') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1">Website URL *</label>
                <input type="url" name="website_url" value="{{ old('website_url') }}" required placeholder="https://...">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1">Claim URL</label>
                <input type="url" name="claim_url" value="{{ old('claim_url') }}" placeholder="https://...">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1">Icon URL</label>
                <input type="url" name="icon_url" value="{{ old('icon_url') }}" placeholder="https://...">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1">Kategori *</label>
                <select name="category" required>
                    <option value="">Pilih kategori</option>
                    <option value="development" {{ old('category') === 'development' ? 'selected' : '' }}>Development</option>
                    <option value="design" {{ old('category') === 'design' ? 'selected' : '' }}>Design</option>
                    <option value="productivity" {{ old('category') === 'productivity' ? 'selected' : '' }}>Produktivitas</option>
                    <option value="learning" {{ old('category') === 'learning' ? 'selected' : '' }}>Pembelajaran</option>
                    <option value="cloud" {{ old('category') === 'cloud' ? 'selected' : '' }}>Cloud & Hosting</option>
                    <option value="communication" {{ old('category') === 'communication' ? 'selected' : '' }}>Komunikasi</option>
                    <option value="ai" {{ old('category') === 'ai' ? 'selected' : '' }}>AI & ML</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-400 mb-1">Benefits (satu per baris)</label>
            <textarea name="benefits_text" rows="4" placeholder="GitHub Pro (unlimited private repos)&#10;GitHub Copilot gratis&#10;dll...">{{ old('benefits_text') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-400 mb-1">Cara Klaim (langkah-langkah)</label>
            <textarea name="how_to_claim" rows="4" placeholder="1. Buka website&#10;2. Masukkan email KVT&#10;3. dll...">{{ old('how_to_claim') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-400 mb-1">Persyaratan (satu per baris)</label>
            <textarea name="requirements_text" rows="3" placeholder="Email KVT aktif&#10;Status pelajar aktif">{{ old('requirements_text') }}</textarea>
        </div>

        <div class="flex items-center gap-6">
            <label class="flex items-center gap-2 text-sm text-gray-400 cursor-pointer">
                <input type="checkbox" name="requires_kvt_email" value="1" {{ old('requires_kvt_email', true) ? 'checked' : '' }} class="!w-4 !h-4 !p-0 rounded">
                Butuh Email KVT
            </label>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-white/5">
            <a href="{{ route('admin.edu-tools.index') }}" class="px-5 py-2 rounded-lg bg-white/5 text-gray-400 text-sm hover:bg-white/10">Batal</a>
            <button type="submit" class="px-6 py-2 bg-white text-black rounded-lg text-sm font-bold hover:bg-gray-200 transition-all">Simpan</button>
        </div>
    </form>
</div>
@endsection
