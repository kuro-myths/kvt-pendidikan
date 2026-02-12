@extends('layouts.dashboard')

@section('title', 'Tambah Kelas')
@section('page-title', 'Tambah Kelas')
@section('page-subtitle', 'Buat kelas baru')

@section('content')
<div class="max-w-2xl">
    <div class="bg-zinc-950 border border-white/5 rounded-2xl p-8">
        <form action="{{ route('classes.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5">Nama Kelas <span class="text-red-400">*</span></label>
                <input type="text" name="nama_kelas" value="{{ old('nama_kelas') }}" placeholder="Contoh: XII RPL 1" required>
                @error('nama_kelas')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">Jurusan</label>
                    <input type="text" name="jurusan" value="{{ old('jurusan') }}" placeholder="Contoh: RPL, TKJ, dll">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">Tingkat <span class="text-red-400">*</span></label>
                    <select name="tingkat" required>
                        <option value="">Pilih</option>
                        @for($i = 10; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ old('tingkat') == $i ? 'selected' : '' }}>Tingkat {{ $i }}</option>
                        @endfor
                    </select>
                    @error('tingkat')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">Tahun Ajaran <span class="text-red-400">*</span></label>
                    <input type="text" name="tahun_ajaran" value="{{ old('tahun_ajaran', date('Y') . '/' . (date('Y') + 1)) }}" placeholder="2025/2026" required>
                    @error('tahun_ajaran')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">Semester <span class="text-red-400">*</span></label>
                    <select name="semester" required>
                        <option value="ganjil" {{ old('semester') == 'ganjil' ? 'selected' : '' }}>Semester 1 (Ganjil)</option>
                        <option value="genap" {{ old('semester') == 'genap' ? 'selected' : '' }}>Semester 2 (Genap)</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5">Wali Kelas</label>
                <select name="wali_kelas_id">
                    <option value="">Pilih Guru</option>
                    @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ old('wali_kelas_id') == $teacher->id ? 'selected' : '' }}>{{ $teacher->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5">Pilih Siswa</label>
                <div class="bg-white/5 rounded-xl p-4 max-h-60 overflow-y-auto space-y-2">
                    @forelse($students as $student)
                    <label class="flex items-center gap-3 p-2 rounded-lg hover:bg-white/5 cursor-pointer">
                        <input type="checkbox" name="students[]" value="{{ $student->id }}" {{ in_array($student->id, old('students', [])) ? 'checked' : '' }}
                            class="rounded bg-white/10 border-white/20 text-white focus:ring-white/30">
                        <span class="text-sm text-white">{{ $student->nama }}</span>
                        <span class="text-xs text-gray-500 font-mono ml-auto">{{ $student->nisn ?? '-' }}</span>
                    </label>
                    @empty
                    <p class="text-gray-500 text-sm text-center py-4">Belum ada siswa terdaftar.</p>
                    @endforelse
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-white text-black px-6 py-3 rounded-xl text-sm font-bold hover:bg-gray-200 transition-all">Buat Kelas</button>
                <a href="{{ route('classes.index') }}" class="border border-white/10 text-gray-400 px-6 py-3 rounded-xl text-sm font-medium hover:border-white/30 transition-all">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
