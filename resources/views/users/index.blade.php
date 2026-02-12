@extends('layouts.dashboard')

@section('title', 'Kelola Guru & Siswa')
@section('page-title', 'Guru & Siswa')
@section('page-subtitle', 'Kelola data guru dan siswa')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div class="bg-zinc-950 border border-white/5 rounded-2xl p-4 flex-1 mr-4">
        <form action="" method="GET" class="flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, atau NISN...">
            </div>
            <div class="w-36">
                <select name="role">
                    <option value="">Semua Role</option>
                    <option value="guru" {{ request('role') == 'guru' ? 'selected' : '' }}>Guru</option>
                    <option value="siswa" {{ request('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                </select>
            </div>
            <button type="submit" class="bg-white text-black px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-200 transition-all">Filter</button>
        </form>
    </div>
    <a href="{{ route('users.create') }}" class="bg-white text-black px-5 py-3 rounded-xl text-sm font-bold hover:bg-gray-200 transition-all whitespace-nowrap flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
        Tambah User
    </a>
</div>

<div class="bg-zinc-950 border border-white/5 rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-white/5">
                    <th class="text-left px-6 py-4 text-gray-500 font-medium text-xs uppercase">User</th>
                    <th class="text-left px-6 py-4 text-gray-500 font-medium text-xs uppercase">Email KVT</th>
                    <th class="text-left px-6 py-4 text-gray-500 font-medium text-xs uppercase">Role</th>
                    <th class="text-left px-6 py-4 text-gray-500 font-medium text-xs uppercase">NISN/NIP</th>
                    <th class="text-left px-6 py-4 text-gray-500 font-medium text-xs uppercase">Status</th>
                    <th class="text-right px-6 py-4 text-gray-500 font-medium text-xs uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr class="border-b border-white/5 hover:bg-white/[0.02] transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-xs font-bold text-gray-400">
                                {{ strtoupper(substr($user->nama, 0, 1)) }}
                            </div>
                            <span class="text-white font-medium">{{ $user->nama }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-400 font-mono text-xs">{{ $user->kvt_email ?? $user->email }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $user->role === 'guru' ? 'bg-blue-500/10 text-blue-400' : 'bg-green-500/10 text-green-400' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-400 text-xs">{{ $user->nisn ?? $user->nip ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $user->status === 'aktif' ? 'bg-green-500/10 text-green-400' : 'bg-gray-500/10 text-gray-400' }}">
                            {{ ucfirst($user->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('users.edit', $user) }}" class="bg-white/5 text-gray-400 px-3 py-1.5 rounded-lg text-xs hover:bg-white/10 transition-colors">Edit</a>
                            <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus user ini?')">
                                @csrf @method('DELETE')
                                <button class="bg-red-500/10 text-red-400 px-3 py-1.5 rounded-lg text-xs hover:bg-red-500/20 transition-colors">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-12 text-center text-gray-600">Tidak ada user ditemukan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="px-6 py-4 border-t border-white/5">{{ $users->withQueryString()->links() }}</div>
    @endif
</div>
@endsection
