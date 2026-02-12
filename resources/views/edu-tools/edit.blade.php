@extends('layouts.dashboard')

@section('title', 'Edit ' . $eduTool->name . ' — Admin')
@section('page-title', 'Edit Edu Tool')
@section('page-subtitle', $eduTool->name)

@section('content')
<div class="max-w-3xl mx-auto">
    <a href="{{ route('admin.edu-tools.index') }}" class="inline-flex items-center gap-2 text-gray-400 hover:text-white text-sm transition-colors mb-6">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali
    </a>

    <form action="{{ route('admin.edu-tools.update', $eduTool) }}" method="POST" class="bg-zinc-900/60 border border-white/5 rounded-xl p-6 space-y-5">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1">Nama Tool *</label>
                <input type="text" name="name" value="{{ old('name', $eduTool->name) }}" required>
                @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1">Slug *</label>
                <input type="text" name="slug" value="{{ old('slug', $eduTool->slug) }}" required>
                @error('slug') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-400 mb-1">Deskripsi Singkat *</label>
            <input type="text" name="short_description" value="{{ old('short_description', $eduTool->short_description) }}" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-400 mb-1">Deskripsi Lengkap *</label>
            <textarea name="description" rows="4" required>{{ old('description', $eduTool->description) }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1">Website URL *</label>
                <input type="url" name="website_url" value="{{ old('website_url', $eduTool->website_url) }}" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1">Claim URL</label>
                <input type="url" name="claim_url" value="{{ old('claim_url', $eduTool->claim_url) }}">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1">Icon URL</label>
                <input type="url" name="icon_url" value="{{ old('icon_url', $eduTool->icon_url) }}">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1">Kategori *</label>
                <select name="category" required>
                    @foreach(['development' => 'Development', 'design' => 'Design', 'productivity' => 'Produktivitas', 'learning' => 'Pembelajaran', 'cloud' => 'Cloud & Hosting', 'communication' => 'Komunikasi', 'ai' => 'AI & ML'] as $val => $label)
                    <option value="{{ $val }}" {{ old('category', $eduTool->category) === $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-400 mb-1">Benefits (satu per baris)</label>
            <textarea name="benefits_text" rows="4">{{ old('benefits_text', $eduTool->benefits ? implode("\n", $eduTool->benefits) : '') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-400 mb-1">Cara Klaim</label>
            <textarea name="how_to_claim" rows="4">{{ old('how_to_claim', $eduTool->how_to_claim) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-400 mb-1">Persyaratan (satu per baris)</label>
            <textarea name="requirements_text" rows="3">{{ old('requirements_text', $eduTool->requirements ? implode("\n", $eduTool->requirements) : '') }}</textarea>
        </div>

        <div class="flex items-center gap-6">
            <label class="flex items-center gap-2 text-sm text-gray-400 cursor-pointer">
                <input type="checkbox" name="requires_kvt_email" value="1" {{ old('requires_kvt_email', $eduTool->requires_kvt_email) ? 'checked' : '' }} class="!w-4 !h-4 !p-0 rounded">
                Butuh Email KVT
            </label>
            <label class="flex items-center gap-2 text-sm text-gray-400 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $eduTool->is_active) ? 'checked' : '' }} class="!w-4 !h-4 !p-0 rounded">
                Aktif
            </label>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-white/5">
            <a href="{{ route('admin.edu-tools.index') }}" class="px-5 py-2 rounded-lg bg-white/5 text-gray-400 text-sm hover:bg-white/10">Batal</a>
            <button type="submit" class="px-6 py-2 bg-white text-black rounded-lg text-sm font-bold hover:bg-gray-200 transition-all">Update</button>
        </div>
    </form>
</div>
@endsection
