<?php

namespace App\Http\Controllers;

use App\Models\EduTool;
use App\Models\UserEduTool;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EduToolController extends Controller
{
    /**
     * Katalog semua edu tools (semua role bisa lihat)
     */
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $category = $request->get('category');
        $search = $request->get('search');

        $query = EduTool::active()->orderBy('sort_order');

        if ($category) {
            $query->byCategory($category);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        $tools = $query->get();

        // Ambil status klaim user saat ini
        $claimedToolIds = $user->eduTools()->pluck('edu_tool_id')->toArray();
        $claimStatuses = $user->eduTools()
            ->get()
            ->keyBy('pivot.edu_tool_id')
            ->map(fn($t) => $t->pivot->status);

        $categories = [
            'development' => ['label' => 'Development', 'icon' => '💻', 'count' => EduTool::active()->byCategory('development')->count()],
            'design' => ['label' => 'Design', 'icon' => '🎨', 'count' => EduTool::active()->byCategory('design')->count()],
            'productivity' => ['label' => 'Produktivitas', 'icon' => '⚡', 'count' => EduTool::active()->byCategory('productivity')->count()],
            'learning' => ['label' => 'Pembelajaran', 'icon' => '📚', 'count' => EduTool::active()->byCategory('learning')->count()],
            'cloud' => ['label' => 'Cloud & Hosting', 'icon' => '☁️', 'count' => EduTool::active()->byCategory('cloud')->count()],
            'communication' => ['label' => 'Komunikasi', 'icon' => '💬', 'count' => EduTool::active()->byCategory('communication')->count()],
            'ai' => ['label' => 'AI & ML', 'icon' => '🤖', 'count' => EduTool::active()->byCategory('ai')->count()],
        ];

        $totalClaimed = $user->eduTools()->wherePivot('status', 'aktif')->count();

        return view('edu-tools.index', compact(
            'tools',
            'categories',
            'claimedToolIds',
            'claimStatuses',
            'category',
            'search',
            'user',
            'totalClaimed'
        ));
    }

    /**
     * Detail satu edu tool
     */
    public function show(EduTool $eduTool)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $claimStatus = $user->eduTools()
            ->where('edu_tool_id', $eduTool->id)
            ->first()?->pivot?->status;

        $claimRecord = UserEduTool::where('user_id', $user->id)
            ->where('edu_tool_id', $eduTool->id)
            ->first();

        // Berapa user lain yang sudah klaim
        $totalClaimers = $eduTool->claimedBy()->count();

        return view('edu-tools.show', compact('eduTool', 'user', 'claimStatus', 'claimRecord', 'totalClaimers'));
    }

    /**
     * Klaim/aktivasi edu tool
     */
    public function claim(EduTool $eduTool)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Cek apakah sudah pernah klaim
        $existing = UserEduTool::where('user_id', $user->id)
            ->where('edu_tool_id', $eduTool->id)
            ->first();

        if ($existing && in_array($existing->status, ['aktif', 'pending'])) {
            return back()->with('error', 'Kamu sudah mengklaim tool ini.');
        }

        // Cek apakah butuh KVT email
        if ($eduTool->requires_kvt_email && !$user->kvt_email) {
            return back()->with('error', 'Kamu membutuhkan email KVT untuk mengklaim tool ini. Hubungi admin sekolah.');
        }

        // Buat klaim baru atau update yang expired/ditolak
        if ($existing) {
            $existing->update([
                'status' => 'pending',
                'claimed_at' => now(),
                'kvt_email_used' => $user->kvt_email,
                'notes' => null,
            ]);
        } else {
            UserEduTool::create([
                'user_id' => $user->id,
                'edu_tool_id' => $eduTool->id,
                'kvt_email_used' => $user->kvt_email,
                'status' => 'pending',
                'claimed_at' => now(),
            ]);
        }

        ActivityLog::log('edu_tool_claim', "Mengklaim edu tool: {$eduTool->name}");

        return back()->with('success', "Berhasil mengklaim {$eduTool->name}! Status: menunggu verifikasi.");
    }

    /**
     * My edu tools — tools yang sudah diklaim user
     */
    public function myTools()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $myTools = UserEduTool::where('user_id', $user->id)
            ->with('eduTool')
            ->orderByDesc('claimed_at')
            ->get();

        $activeCount = $myTools->where('status', 'aktif')->count();
        $pendingCount = $myTools->where('status', 'pending')->count();

        return view('edu-tools.my-tools', compact('myTools', 'user', 'activeCount', 'pendingCount'));
    }

    /**
     * Admin: manage semua klaim edu tools
     */
    public function adminIndex(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $status = $request->get('status');
        $query = UserEduTool::with(['user', 'eduTool'])->orderByDesc('created_at');

        if ($status) {
            $query->where('status', $status);
        }

        $claims = $query->paginate(20);
        $tools = EduTool::active()->orderBy('sort_order')->get();

        $stats = [
            'total' => UserEduTool::count(),
            'aktif' => UserEduTool::where('status', 'aktif')->count(),
            'pending' => UserEduTool::where('status', 'pending')->count(),
            'tools_count' => EduTool::active()->count(),
        ];

        return view('edu-tools.admin', compact('claims', 'tools', 'stats', 'status'));
    }

    /**
     * Admin: approve klaim
     */
    public function approve(UserEduTool $userEduTool)
    {
        $userEduTool->update([
            'status' => 'aktif',
            'expires_at' => now()->addYear(),
        ]);

        ActivityLog::log(
            'edu_tool_approve',
            "Menyetujui klaim {$userEduTool->eduTool->name} untuk {$userEduTool->user->nama}"
        );

        return back()->with('success', "Klaim {$userEduTool->eduTool->name} disetujui.");
    }

    /**
     * Admin: reject klaim
     */
    public function reject(Request $request, UserEduTool $userEduTool)
    {
        $userEduTool->update([
            'status' => 'ditolak',
            'notes' => $request->get('notes', 'Ditolak oleh admin'),
        ]);

        ActivityLog::log(
            'edu_tool_reject',
            "Menolak klaim {$userEduTool->eduTool->name} untuk {$userEduTool->user->nama}"
        );

        return back()->with('success', "Klaim {$userEduTool->eduTool->name} ditolak.");
    }

    /**
     * Admin: manage katalog tools (CRUD)
     */
    public function create()
    {
        return view('edu-tools.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:edu_tools',
            'short_description' => 'required|string|max:500',
            'description' => 'required|string',
            'icon_url' => 'nullable|url',
            'website_url' => 'required|url',
            'claim_url' => 'nullable|url',
            'category' => 'required|in:development,design,productivity,learning,cloud,communication,ai',
            'how_to_claim' => 'nullable|string',
            'requires_kvt_email' => 'boolean',
        ]);

        $validated['requires_kvt_email'] = $request->boolean('requires_kvt_email');

        // Handle benefits & requirements as JSON arrays
        if ($request->filled('benefits_text')) {
            $validated['benefits'] = array_filter(array_map('trim', explode("\n", $request->benefits_text)));
        }
        if ($request->filled('requirements_text')) {
            $validated['requirements'] = array_filter(array_map('trim', explode("\n", $request->requirements_text)));
        }

        $tool = EduTool::create($validated);

        ActivityLog::log('edu_tool_create', "Menambahkan edu tool: {$tool->name}");

        return redirect()->route('admin.edu-tools.index')
            ->with('success', "Tool {$tool->name} berhasil ditambahkan.");
    }

    public function edit(EduTool $eduTool)
    {
        return view('edu-tools.edit', compact('eduTool'));
    }

    public function update(Request $request, EduTool $eduTool)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:edu_tools,slug,' . $eduTool->id,
            'short_description' => 'required|string|max:500',
            'description' => 'required|string',
            'icon_url' => 'nullable|url',
            'website_url' => 'required|url',
            'claim_url' => 'nullable|url',
            'category' => 'required|in:development,design,productivity,learning,cloud,communication,ai',
            'how_to_claim' => 'nullable|string',
            'requires_kvt_email' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $validated['requires_kvt_email'] = $request->boolean('requires_kvt_email');
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->filled('benefits_text')) {
            $validated['benefits'] = array_filter(array_map('trim', explode("\n", $request->benefits_text)));
        }
        if ($request->filled('requirements_text')) {
            $validated['requirements'] = array_filter(array_map('trim', explode("\n", $request->requirements_text)));
        }

        $eduTool->update($validated);

        ActivityLog::log('edu_tool_update', "Mengupdate edu tool: {$eduTool->name}");

        return redirect()->route('admin.edu-tools.index')
            ->with('success', "Tool {$eduTool->name} berhasil diupdate.");
    }

    public function destroy(EduTool $eduTool)
    {
        $name = $eduTool->name;
        $eduTool->delete();

        ActivityLog::log('edu_tool_delete', "Menghapus edu tool: {$name}");

        return redirect()->route('admin.edu-tools.index')
            ->with('success', "Tool {$name} berhasil dihapus.");
    }
}
