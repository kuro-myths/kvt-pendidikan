@extends('layouts.dashboard')

@section('title', 'Edit Lisensi')
@section('page-title', 'Edit Lisensi')
@section('page-subtitle', ucfirst($license->tipe_lisensi) . ' — ' . ($license->school->nama_sekolah ?? '-'))

@section('content')
<div class="max-w-2xl">
    <div class="bg-zinc-950 border border-white/5 rounded-2xl p-8">
        <form action="{{ route('admin.licenses.update', $license) }}" method="POST" class="space-y-5">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5">Sekolah</label>
                <div class="bg-white/5 rounded-xl p-4">
                    <p class="text-white font-semibold">{{ $license->school->nama_sekolah ?? '-' }}</p>
                    <p class="text-gray-500 text-xs font-mono">{{ $license->school->school_code ?? '-' }}</p>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-1.5">Tipe Lisensi <span class="text-red-400">*</span></label>
                <div class="grid grid-cols-3 gap-3">
                    @foreach(['basic' => 'Basic', 'pro' => 'Pro', 'premium' => 'Premium'] as $key => $label)
                    <label class="cursor-pointer">
                        <input type="radio" name="tipe_lisensi" value="{{ $key }}" {{ old('tipe_lisensi', $license->tipe_lisensi) == $key ? 'checked' : '' }} class="peer hidden">
                        <div class="peer-checked:border-white peer-checked:bg-white/5 border border-white/10 rounded-xl p-4 text-center transition-all hover:border-white/30">
                            <p class="text-white font-bold text-sm">{{ $label }}</p>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">Berlaku Mulai</label>
                    <input type="date" name="berlaku_mulai" value="{{ old('berlaku_mulai', $license->berlaku_mulai->format('Y-m-d')) }}" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">Berlaku Sampai</label>
                    <input type="date" name="berlaku_sampai" value="{{ old('berlaku_sampai', $license->berlaku_sampai->format('Y-m-d')) }}" required>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">Max Guru</label>
                    <input type="number" name="max_guru" value="{{ old('max_guru', $license->max_guru) }}" min="1" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">Max Siswa</label>
                    <input type="number" name="max_siswa" value="{{ old('max_siswa', $license->max_siswa) }}" min="1" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-1.5">Max Kelas</label>
                    <input type="number" name="max_kelas" value="{{ old('max_kelas', $license->max_kelas) }}" min="1" required>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-white text-black px-6 py-3 rounded-xl text-sm font-bold hover:bg-gray-200 transition-all">Simpan</button>
                <a href="{{ role_route('licenses.index') }}" class="border border-white/10 text-gray-400 px-6 py-3 rounded-xl text-sm font-medium hover:border-white/30 transition-all">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
