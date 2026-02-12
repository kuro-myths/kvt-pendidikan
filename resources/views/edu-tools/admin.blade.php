@extends('layouts.dashboard')

@section('title', 'Kelola Edu Tools — Admin')
@section('page-title', 'Kelola Edu Tools')
@section('page-subtitle', 'Manage katalog & klaim edu tools')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-zinc-900/60 border border-white/5 rounded-xl p-4">
            <p class="text-2xl font-bold text-white">{{ $stats['tools_count'] }}</p>
            <p class="text-xs text-gray-500">Tools Aktif</p>
        </div>
        <div class="bg-zinc-900/60 border border-white/5 rounded-xl p-4">
            <p class="text-2xl font-bold text-green-400">{{ $stats['aktif'] }}</p>
            <p class="text-xs text-gray-500">Klaim Disetujui</p>
        </div>
        <div class="bg-zinc-900/60 border border-white/5 rounded-xl p-4">
            <p class="text-2xl font-bold text-yellow-400">{{ $stats['pending'] }}</p>
            <p class="text-xs text-gray-500">Menunggu Verifikasi</p>
        </div>
        <div class="bg-zinc-900/60 border border-white/5 rounded-xl p-4">
            <p class="text-2xl font-bold text-cyan-400">{{ $stats['total'] }}</p>
            <p class="text-xs text-gray-500">Total Klaim</p>
        </div>
    </div>

    {{-- Actions --}}
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div class="flex gap-2">
            <a href="{{ route('admin.edu-tools.index') }}" class="px-4 py-2 rounded-lg text-sm {{ !$status ? 'bg-white text-black font-bold' : 'bg-zinc-800 text-gray-400 hover:text-white' }}">Semua</a>
            <a href="{{ route('admin.edu-tools.index', ['status' => 'pending']) }}" class="px-4 py-2 rounded-lg text-sm {{ $status === 'pending' ? 'bg-yellow-500 text-black font-bold' : 'bg-zinc-800 text-gray-400 hover:text-white' }}">Pending ({{ $stats['pending'] }})</a>
            <a href="{{ route('admin.edu-tools.index', ['status' => 'aktif']) }}" class="px-4 py-2 rounded-lg text-sm {{ $status === 'aktif' ? 'bg-green-500 text-black font-bold' : 'bg-zinc-800 text-gray-400 hover:text-white' }}">Aktif</a>
        </div>
        <a href="{{ route('admin.edu-tools.create') }}" class="px-5 py-2 bg-white text-black rounded-lg text-sm font-bold hover:bg-gray-200 transition-all flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Tool
        </a>
    </div>

    {{-- Claims Table --}}
    <div class="bg-zinc-900/60 border border-white/5 rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left border-b border-white/5">
                        <th class="px-5 py-3 text-gray-500 font-medium">User</th>
                        <th class="px-5 py-3 text-gray-500 font-medium">Tool</th>
                        <th class="px-5 py-3 text-gray-500 font-medium">Email KVT</th>
                        <th class="px-5 py-3 text-gray-500 font-medium">Tanggal</th>
                        <th class="px-5 py-3 text-gray-500 font-medium">Status</th>
                        <th class="px-5 py-3 text-gray-500 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($claims as $claim)
                    <tr class="hover:bg-white/5 transition-colors">
                        <td class="px-5 py-3">
                            <div>
                                <p class="text-white font-medium">{{ $claim->user->nama ?? '-' }}</p>
                                <p class="text-gray-500 text-xs">{{ $claim->user->role ?? '-' }}</p>
                            </div>
                        </td>
                        <td class="px-5 py-3">
                            <span class="text-white">{{ $claim->eduTool->name ?? '-' }}</span>
                        </td>
                        <td class="px-5 py-3">
                            <span class="text-cyan-400 font-mono text-xs">{{ $claim->kvt_email_used ?? '-' }}</span>
                        </td>
                        <td class="px-5 py-3 text-gray-400">
                            {{ $claim->claimed_at?->format('d M Y') ?? $claim->created_at->format('d M Y') }}
                        </td>
                        <td class="px-5 py-3">
                            @if($claim->status === 'aktif')
                            <span class="px-2 py-1 rounded-full text-xs font-bold bg-green-500/20 text-green-400">Aktif</span>
                            @elseif($claim->status === 'pending')
                            <span class="px-2 py-1 rounded-full text-xs font-bold bg-yellow-500/20 text-yellow-400">Pending</span>
                            @elseif($claim->status === 'ditolak')
                            <span class="px-2 py-1 rounded-full text-xs font-bold bg-red-500/20 text-red-400">Ditolak</span>
                            @else
                            <span class="px-2 py-1 rounded-full text-xs font-bold bg-gray-500/20 text-gray-400">{{ $claim->status }}</span>
                            @endif
                        </td>
                        <td class="px-5 py-3">
                            @if($claim->status === 'pending')
                            <div class="flex items-center gap-2">
                                <form action="{{ route('admin.edu-tools.approve', $claim) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 rounded bg-green-500/20 text-green-400 text-xs font-medium hover:bg-green-500/30 transition-all">Setujui</button>
                                </form>
                                <form action="{{ route('admin.edu-tools.reject', $claim) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 rounded bg-red-500/20 text-red-400 text-xs font-medium hover:bg-red-500/30 transition-all">Tolak</button>
                                </form>
                            </div>
                            @else
                            <span class="text-gray-600 text-xs">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-12 text-center text-gray-600">Belum ada klaim edu tools</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($claims->hasPages())
        <div class="px-5 py-4 border-t border-white/5">
            {{ $claims->withQueryString()->links() }}
        </div>
        @endif
    </div>

    {{-- Tools Catalog Management --}}
    <div class="mt-8">
        <h3 class="text-white font-bold text-lg mb-4">Katalog Tools</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach($tools as $tool)
            <div class="bg-zinc-900/60 border border-white/5 rounded-xl p-4 flex items-center justify-between hover:border-white/10 transition-all">
                <div class="flex items-center gap-3">
                    @if($tool->icon_url)
                    <div class="w-10 h-10 rounded-lg bg-white/10 flex items-center justify-center overflow-hidden flex-shrink-0">
                        <img src="{{ $tool->icon_url }}" alt="" class="w-6 h-6 object-contain" onerror="this.parentElement.innerHTML='🔧'">
                    </div>
                    @endif
                    <div>
                        <p class="text-white font-medium text-sm">{{ $tool->name }}</p>
                        <p class="text-gray-500 text-xs">{{ $tool->category_label }} · {{ $tool->claimedBy()->count() }} users</p>
                    </div>
                </div>
                <div class="flex items-center gap-1">
                    <a href="{{ route('admin.edu-tools.edit', $tool) }}" class="p-2 rounded-lg hover:bg-white/10 text-gray-400 hover:text-white transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </a>
                    <form action="{{ route('admin.edu-tools.destroy', $tool) }}" method="POST" onsubmit="return confirm('Hapus tool {{ $tool->name }}?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="p-2 rounded-lg hover:bg-red-500/10 text-gray-400 hover:text-red-400 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
