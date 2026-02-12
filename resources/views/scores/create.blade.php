@extends('layouts.dashboard')

@section('title', 'Input Nilai KVT')
@section('page-title', 'Input Nilai KVT')
@section('page-subtitle', 'Masukkan nilai kompetensi siswa')

@section('content')
<div class="max-w-2xl">
    <div class="bg-zinc-950 border border-white/5 rounded-2xl p-8">
        <form action="{{ role_route('scores.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5">Kelas <span class="text-red-400">*</span></label>
                <select name="class_id" id="classSelect" required>
                    <option value="">Pilih Kelas</option>
                    @foreach($classes as $class)
                    <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>{{ $class->nama_kelas }} — {{ $class->jurusan }}</option>
                    @endforeach
                </select>
                @error('class_id')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5">Siswa <span class="text-red-400">*</span></label>
                <select name="student_id" required>
                    <option value="">Pilih Siswa</option>
                    @foreach($students as $student)
                    <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>{{ $student->nama }} — {{ $student->nisn ?? 'No NISN' }}</option>
                    @endforeach
                </select>
                @error('student_id')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5">Kompetensi <span class="text-red-400">*</span></label>
                <input type="text" name="kompetensi" value="{{ old('kompetensi') }}" placeholder="Contoh: Pemrograman Web, Basis Data" required>
                @error('kompetensi')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5">Nilai (0 - 100) <span class="text-red-400">*</span></label>
                <input type="number" name="nilai" value="{{ old('nilai') }}" min="0" max="100" step="0.1" placeholder="85.5" required>
                @error('nilai')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">Semester <span class="text-red-400">*</span></label>
                    <select name="semester" required>
                        <option value="ganjil" {{ old('semester') == 'ganjil' ? 'selected' : '' }}>Semester 1 (Ganjil)</option>
                        <option value="genap" {{ old('semester') == 'genap' ? 'selected' : '' }}>Semester 2 (Genap)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">Tahun Ajaran <span class="text-red-400">*</span></label>
                    <input type="text" name="tahun_ajaran" value="{{ old('tahun_ajaran', date('Y') . '/' . (date('Y') + 1)) }}" required>
                </div>
            </div>

            <div class="bg-white/5 rounded-xl p-4">
                <p class="text-gray-400 text-xs"><strong class="text-white">Info:</strong> Predikat akan dihitung otomatis — A (≥90), B (≥80), C (≥70), D (≥60), E (&lt;60).</p>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-white text-black px-6 py-3 rounded-xl text-sm font-bold hover:bg-gray-200 transition-all">Simpan Nilai</button>
                <a href="{{ role_route('scores.index') }}" class="border border-white/10 text-gray-400 px-6 py-3 rounded-xl text-sm font-medium hover:border-white/30 transition-all">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
