@extends('layouts.dashboard')

@section('title', 'Tambah Lisensi')
@section('page-title', 'Tambah Lisensi')
@section('page-subtitle', 'Berikan lisensi untuk sekolah')

@section('content')
<div class="max-w-2xl">
    <div class="bg-zinc-950 border border-white/5 rounded-2xl p-8">
        <form action="{{ route('licenses.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5">Sekolah <span class="text-red-400">*</span></label>
                <select name="school_id" required>
                    <option value="">Pilih Sekolah</option>
                    @foreach($schools as $school)
                    <option value="{{ $school->id }}" {{ old('school_id') == $school->id ? 'selected' : '' }}>{{ $school->nama_sekolah }} ({{ $school->school_code }})</option>
                    @endforeach
                </select>
                @error('school_id')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5">Tipe Lisensi <span class="text-red-400">*</span></label>
                <div class="grid grid-cols-3 gap-3">
                    @foreach(['basic' => ['Basic', 'Max 10 Guru, 100 Siswa, 5 Kelas'], 'pro' => ['Pro', 'Max 30 Guru, 500 Siswa, 15 Kelas'], 'premium' => ['Premium', 'Max 100 Guru, 2000 Siswa, 50 Kelas']] as $key => [$label, $desc])
                    <label class="cursor-pointer">
                        <input type="radio" name="tipe_lisensi" value="{{ $key }}" {{ old('tipe_lisensi') == $key ? 'checked' : '' }} class="peer hidden">
                        <div class="peer-checked:border-white peer-checked:bg-white/5 border border-white/10 rounded-xl p-4 text-center transition-all hover:border-white/30">
                            <p class="text-white font-bold text-sm">{{ $label }}</p>
                            <p class="text-gray-500 text-[10px] mt-1">{{ $desc }}</p>
                        </div>
                    </label>
                    @endforeach
                </div>
                @error('tipe_lisensi')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">Berlaku Mulai <span class="text-red-400">*</span></label>
                    <input type="date" name="berlaku_mulai" value="{{ old('berlaku_mulai', date('Y-m-d')) }}" required>
                    @error('berlaku_mulai')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">Berlaku Sampai <span class="text-red-400">*</span></label>
                    <input type="date" name="berlaku_sampai" value="{{ old('berlaku_sampai', date('Y-m-d', strtotime('+1 year'))) }}" required>
                    @error('berlaku_sampai')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="bg-white/5 rounded-xl p-4">
                <p class="text-gray-400 text-xs"><strong class="text-white">Info:</strong> Lisensi aktif sebelumnya akan otomatis dinonaktifkan saat lisensi baru dibuat untuk sekolah yang sama.</p>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-white text-black px-6 py-3 rounded-xl text-sm font-bold hover:bg-gray-200 transition-all">Buat Lisensi</button>
                <a href="{{ route('licenses.index') }}" class="border border-white/10 text-gray-400 px-6 py-3 rounded-xl text-sm font-medium hover:border-white/30 transition-all">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
