<?php

namespace App\Http\Controllers;

use App\Models\KvtScore;
use App\Models\SchoolClass;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KvtScoreController extends Controller
{
    public function index(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $query = KvtScore::with(['student', 'schoolClass', 'penilai']);

        if ($user->isGuru()) {
            $query->where('dinilai_oleh', $user->id);
        } elseif ($user->isSiswa()) {
            $query->where('student_id', $user->id);
        } elseif (!$user->isAdminKvt()) {
            $query->where('school_id', $user->school_id);
        }

        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }
        if ($request->filled('tahun_ajaran')) {
            $query->where('tahun_ajaran', $request->tahun_ajaran);
        }
        if ($request->filled('search')) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('nama', 'like', "%{$request->search}%");
            });
        }

        $scores = $query->latest()->paginate(15);

        return view('scores.index', compact('scores'));
    }

    public function create()
    {
        /** @var User $user */
        $user = Auth::user();
        $classes = SchoolClass::where('school_id', $user->school_id)->aktif()->with('students')->get();
        $students = User::where('school_id', $user->school_id)->where('role', 'siswa')->aktif()->get();

        return view('scores.create', compact('classes', 'students'));
    }

    public function store(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'student_id' => 'required|exists:users,id',
            'class_id' => 'required|exists:classes,id',
            'kompetensi' => 'required|string|max:255',
            'sub_kompetensi' => 'nullable|string|max:255',
            'nilai' => 'required|numeric|min:0|max:100',
            'semester' => 'required|in:ganjil,genap',
            'tahun_ajaran' => 'required|string',
            'catatan' => 'nullable|string',
        ]);

        $predikat = KvtScore::hitungPredikat((float) $request->nilai);

        $score = KvtScore::create([
            'student_id' => $request->student_id,
            'class_id' => $request->class_id,
            'school_id' => $user->school_id,
            'kompetensi' => $request->kompetensi,
            'sub_kompetensi' => $request->sub_kompetensi,
            'nilai' => $request->nilai,
            'predikat' => $predikat,
            'semester' => $request->semester,
            'tahun_ajaran' => $request->tahun_ajaran,
            'catatan' => $request->catatan,
            'dinilai_oleh' => $user->id,
        ]);

        ActivityLog::log('create_score', "Nilai KVT ditambahkan untuk siswa ID {$request->student_id}", $score);

        return redirect(role_route('scores.index'))->with('success', 'Nilai KVT berhasil ditambahkan.');
    }

    public function show(KvtScore $score)
    {
        /** @var User $user */
        $user = Auth::user();

        // Authorization: siswa can only view own scores
        if ($user->isSiswa() && $score->student_id !== $user->id) {
            abort(403);
        }

        // guru can only view scores they created
        if ($user->isGuru() && $score->dinilai_oleh !== $user->id) {
            abort(403);
        }

        // admin_sekolah can only view scores from their school
        if ($user->isAdminSekolah() && $score->school_id !== $user->school_id) {
            abort(403);
        }

        $score->load(['student', 'schoolClass', 'penilai']);
        return view('scores.show', compact('score'));
    }

    public function edit(KvtScore $score)
    {
        /** @var User $user */
        $user = Auth::user();
        $classes = SchoolClass::where('school_id', $user->school_id)->aktif()->with('students')->get();

        return view('scores.edit', compact('score', 'classes'));
    }

    public function update(Request $request, KvtScore $score)
    {
        $request->validate([
            'kompetensi' => 'required|string|max:255',
            'sub_kompetensi' => 'nullable|string|max:255',
            'nilai' => 'required|numeric|min:0|max:100',
            'semester' => 'nullable|in:ganjil,genap',
            'tahun_ajaran' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        $oldData = $score->toArray();
        $predikat = KvtScore::hitungPredikat((float) $request->nilai);

        $score->update([
            'kompetensi' => $request->kompetensi,
            'sub_kompetensi' => $request->sub_kompetensi,
            'nilai' => $request->nilai,
            'predikat' => $predikat,
            'semester' => $request->semester ?? $score->semester,
            'tahun_ajaran' => $request->tahun_ajaran ?? $score->tahun_ajaran,
            'catatan' => $request->catatan,
        ]);

        ActivityLog::log('update_score', 'Nilai KVT diperbarui', $score, $oldData, $score->toArray());

        return redirect(role_route('scores.index'))->with('success', 'Nilai KVT berhasil diperbarui.');
    }

    public function destroy(KvtScore $score)
    {
        ActivityLog::log('delete_score', 'Nilai KVT dihapus', $score);
        $score->delete();

        return redirect(role_route('scores.index'))->with('success', 'Nilai KVT berhasil dihapus.');
    }
}
