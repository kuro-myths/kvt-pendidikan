@extends('layouts.dashboard')

@section('title', 'Edit Nilai KVT')
@section('page-title', 'Edit Nilai')
@section('page-subtitle', $score->student->nama . ' — ' . $score->kompetensi)

@section('content')
<div class="max-w-2xl">
    <div class="bg-zinc-950 border border-white/5 rounded-2xl p-8">
        <div class="flex items-center gap-4 mb-6 pb-6 border-b border-white/5">
            <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center text-lg font-bold">{{ strtoupper(substr($score->student->nama ?? '?', 0, 1)) }}</div>
            <div>
                <h3 class="font-semibold text-white">{{ $score->student->nama ?? '-' }}</h3>
                <p class="text-sm text-gray-500">{{ $score->kompetensi }} — Nilai saat ini: <span class="text-white font-bold">{{ number_format($score->nilai, 1) }}</span> ({{ $score->predikat }})</p>
            </div>
        </div>

        <form action="{{ route('scores.update', $score) }}" method="POST" class="space-y-5">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5">Kompetensi <span class="text-red-400">*</span></label>
                <input type="text" name="kompetensi" value="{{ old('kompetensi', $score->kompetensi) }}" required>
                @error('kompetensi')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5">Nilai (0 - 100) <span class="text-red-400">*</span></label>
                <input type="number" name="nilai" value="{{ old('nilai', $score->nilai) }}" min="0" max="100" step="0.1" required>
                @error('nilai')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">Semester</label>
                    <select name="semester" required>
                        <option value="ganjil" {{ old('semester', $score->semester) == 'ganjil' ? 'selected' : '' }}>Semester 1 (Ganjil)</option>
                        <option value="genap" {{ old('semester', $score->semester) == 'genap' ? 'selected' : '' }}>Semester 2 (Genap)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">Tahun Ajaran</label>
                    <input type="text" name="tahun_ajaran" value="{{ old('tahun_ajaran', $score->tahun_ajaran) }}" required>
                </div>
            </div>

            <div class="bg-white/5 rounded-xl p-4">
                <p class="text-gray-400 text-xs"><strong class="text-white">Info:</strong> Predikat akan dihitung ulang otomatis setelah nilai diubah.</p>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-white text-black px-6 py-3 rounded-xl text-sm font-bold hover:bg-gray-200 transition-all">Update Nilai</button>
                <a href="{{ route('scores.index') }}" class="border border-white/10 text-gray-400 px-6 py-3 rounded-xl text-sm font-medium hover:border-white/30 transition-all">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
