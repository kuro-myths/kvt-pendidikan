<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\School;
use App\Models\SchoolClass;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    public function run(): void
    {
        $school1 = School::where('school_code', 'kvt.1')->first();
        $school3 = School::where('school_code', 'kvt.3')->first();

        $guru1 = User::where('kvt_email', 'budi.santoso@kvt.1')->first();
        $guru2 = User::where('kvt_email', 'siti.aminah@kvt.1')->first();
        $guru3 = User::where('kvt_email', 'andi.wijaya@kvt.3')->first();

        // ── Kelas SMKN 1 Jakarta ──
        $kelas1 = SchoolClass::create([
            'school_id' => $school1->id,
            'nama_kelas' => 'XII RPL 1',
            'jurusan' => 'Rekayasa Perangkat Lunak',
            'tingkat' => 12,
            'tahun_ajaran' => '2025/2026',
            'semester' => 'ganjil',
            'wali_kelas_id' => $guru1->id,
        ]);

        $siswaKelas1 = User::where('school_id', $school1->id)
            ->where('role', 'siswa')
            ->take(3)
            ->pluck('id');
        $kelas1->students()->attach($siswaKelas1);

        $kelas2 = SchoolClass::create([
            'school_id' => $school1->id,
            'nama_kelas' => 'XI TKJ 2',
            'jurusan' => 'Teknik Komputer Jaringan',
            'tingkat' => 11,
            'tahun_ajaran' => '2025/2026',
            'semester' => 'ganjil',
            'wali_kelas_id' => $guru2->id,
        ]);

        $siswaKelas2 = User::where('school_id', $school1->id)
            ->where('role', 'siswa')
            ->skip(2)->take(3)
            ->pluck('id');
        $kelas2->students()->attach($siswaKelas2);

        // ── Kelas SMAN 5 Surabaya ──
        $kelas3 = SchoolClass::create([
            'school_id' => $school3->id,
            'nama_kelas' => 'XII IPA 1',
            'jurusan' => 'IPA',
            'tingkat' => 12,
            'tahun_ajaran' => '2025/2026',
            'semester' => 'ganjil',
            'wali_kelas_id' => $guru3->id,
        ]);

        $siswaSby = User::where('school_id', $school3->id)
            ->where('role', 'siswa')
            ->pluck('id');
        $kelas3->students()->attach($siswaSby);

        $this->command->info('   ✅ ClassSeeder: 3 kelas + siswa terdaftar');
    }
}
