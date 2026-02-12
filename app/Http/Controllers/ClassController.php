<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = SchoolClass::with(['school', 'waliKelas', 'students']);

        if (!$user->isAdminKvt()) {
            $query->where('school_id', $user->school_id);
        }

        if ($request->filled('search')) {
            $query->where('nama_kelas', 'like', "%{$request->search}%");
        }

        $classes = $query->latest()->paginate(15);

        return view('classes.index', compact('classes'));
    }

    public function create()
    {
        $user = auth()->user();
        $teachers = User::where('school_id', $user->school_id)->where('role', 'guru')->aktif()->get();
        $students = User::where('school_id', $user->school_id)->where('role', 'siswa')->aktif()->get();

        return view('classes.create', compact('teachers', 'students'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'jurusan' => 'nullable|string|max:255',
            'tingkat' => 'nullable|string|max:10',
            'tahun_ajaran' => 'required|string',
            'semester' => 'required|in:ganjil,genap',
            'wali_kelas_id' => 'nullable|exists:users,id',
            'students' => 'nullable|array',
            'students.*' => 'exists:users,id',
        ]);

        $class = SchoolClass::create([
            'school_id' => $user->school_id,
            'nama_kelas' => $request->nama_kelas,
            'jurusan' => $request->jurusan,
            'tingkat' => $request->tingkat,
            'tahun_ajaran' => $request->tahun_ajaran,
            'semester' => $request->semester,
            'wali_kelas_id' => $request->wali_kelas_id,
        ]);

        if ($request->filled('students')) {
            $class->students()->attach($request->students);
        }

        ActivityLog::log('create_class', "Kelas {$request->nama_kelas} dibuat", $class);

        return redirect()->route('classes.index')->with('success', 'Kelas berhasil dibuat.');
    }

    public function show(SchoolClass $class)
    {
        $class->load(['school', 'waliKelas', 'students', 'kvtScores']);
        return view('classes.show', compact('class'));
    }

    public function edit(SchoolClass $class)
    {
        $user = auth()->user();
        $teachers = User::where('school_id', $user->school_id)->where('role', 'guru')->aktif()->get();
        $students = User::where('school_id', $user->school_id)->where('role', 'siswa')->aktif()->get();

        return view('classes.edit', compact('class', 'teachers', 'students'));
    }

    public function update(Request $request, SchoolClass $class)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'jurusan' => 'nullable|string|max:255',
            'tingkat' => 'nullable|string|max:10',
            'tahun_ajaran' => 'required|string',
            'semester' => 'required|in:ganjil,genap',
            'wali_kelas_id' => 'nullable|exists:users,id',
            'students' => 'nullable|array',
            'students.*' => 'exists:users,id',
        ]);

        $class->update($request->only(['nama_kelas', 'jurusan', 'tingkat', 'tahun_ajaran', 'semester', 'wali_kelas_id']));

        if ($request->has('students')) {
            $class->students()->sync($request->students ?? []);
        }

        ActivityLog::log('update_class', "Kelas {$class->nama_kelas} diperbarui", $class);

        return redirect()->route('classes.index')->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy(SchoolClass $class)
    {
        ActivityLog::log('delete_class', "Kelas {$class->nama_kelas} dihapus", $class);
        $class->delete();

        return redirect()->route('classes.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
