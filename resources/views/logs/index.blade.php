@extends('layouts.dashboard')

@section('title', 'Activity Log')
@section('page-title', 'Activity Log')
@section('page-subtitle', 'Riwayat aktivitas sistem')

@section('content')
<div class="space-y-6">
    {{-- Search & Filter --}}
    <div class="bg-zinc-950 border border-white/5 rounded-2xl p-6">
        <form method="GET" class="flex flex-wrap items-end gap-4">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-400 mb-1.5">Cari</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari aktivitas...">
            </div>
            <div class="w-48">
                <label class="block text-sm font-medium text-gray-400 mb-1.5">Aksi</label>
                <select name="aksi">
                    <option value="">Semua</option>
                    @foreach(['login', 'logout', 'create_user', 'update_user', 'delete_user', 'create_score', 'update_score', 'delete_score', 'approve_school', 'reject_school', 'toggle_school_status', 'delete_school', 'create_license', 'update_license', 'delete_license', 'password_reset', 'change_password'] as $aksi)
                    <option value="{{ $aksi }}" {{ request('aksi') == $aksi ? 'selected' : '' }}>{{ $aksi }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-white text-black px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-200 transition-all">
                Filter
            </button>
        </form>
    </div>

    {{-- Logs Table --}}
    <div class="bg-zinc-950 border border-white/5 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-white/5">
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Waktu</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">User</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Deskripsi</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">IP</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($logs as $log)
                    <tr class="hover:bg-white/[0.02]">
                        <td class="px-6 py-4 text-gray-400 text-xs whitespace-nowrap">{{ $log->created_at->format('d M Y H:i') }}</td>
                        <td class="px-6 py-4">
                            <span class="text-white text-sm">{{ $log->user->nama ?? '-' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium
                                @if(str_contains($log->aksi, 'login')) bg-blue-500/20 text-blue-400
                                @elseif(str_contains($log->aksi, 'create')) bg-green-500/20 text-green-400
                                @elseif(str_contains($log->aksi, 'update') || str_contains($log->aksi, 'change')) bg-yellow-500/20 text-yellow-400
                                @elseif(str_contains($log->aksi, 'delete')) bg-red-500/20 text-red-400
                                @elseif(str_contains($log->aksi, 'approve')) bg-green-500/20 text-green-400
                                @elseif(str_contains($log->aksi, 'reject')) bg-red-500/20 text-red-400
                                @else bg-gray-500/20 text-gray-400
                                @endif
                            ">
                                {{ $log->aksi }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-300 text-sm max-w-xs truncate">{{ $log->deskripsi }}</td>
                        <td class="px-6 py-4 text-gray-500 text-xs font-mono">{{ $log->ip_address ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-600">Belum ada aktivitas tercatat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $logs->links() }}
</div>
@endsection
