<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\KvtScore;
use Illuminate\Database\Seeder;

class KvtScoreSeeder extends Seeder
{
    public function run(): void
    {
        $school1 = School::where('school_code', 'kvt.1')->first();
        $school3 = School::where('school_code', 'kvt.3')->first();

        $guru1 = User::where('kvt_email', 'budi.santoso@kvt.1')->first();
        $guru3 = User::where('kvt_email', 'andi.wijaya@kvt.3')->first();

        $kelas1 = SchoolClass::where('nama_kelas', 'XII RPL 1')->first();
        $kelas3 = SchoolClass::where('nama_kelas', 'XII IPA 1')->first();

        $kompetensiSmk = [
            'Pemrograman Web',
            'Basis Data',
            'Pemrograman Berorientasi Objek',
            'Administrasi Server',
            'Keamanan Jaringan',
        ];

        $kompetensiSma = [
            'Matematika',
            'Fisika',
            'Kimia',
            'Biologi',
        ];

        // ── Nilai SMKN 1 Jakarta ──
        $siswaSmk = User::where('school_id', $school1->id)
            ->where('role', 'siswa')->get();

        $count = 0;
        foreach ($siswaSmk as $student) {
            foreach (array_slice($kompetensiSmk, 0, 3) as $komp) {
                $nilai = rand(650, 980) / 10;
                KvtScore::create([
                    'student_id' => $student->id,
                    'class_id' => $kelas1->id,
                    'school_id' => $school1->id,
                    'kompetensi' => $komp,
                    'nilai' => $nilai,
                    'predikat' => KvtScore::hitungPredikat($nilai),
                    'semester' => 'ganjil',
                    'tahun_ajaran' => '2025/2026',
                    'dinilai_oleh' => $guru1->id,
                ]);
                $count++;
            }
        }

        // ── Nilai SMAN 5 Surabaya ──
        $siswaSma = User::where('school_id', $school3->id)
            ->where('role', 'siswa')->get();

        foreach ($siswaSma as $student) {
            foreach (array_slice($kompetensiSma, 0, 3) as $komp) {
                $nilai = rand(600, 950) / 10;
                KvtScore::create([
                    'student_id' => $student->id,
                    'class_id' => $kelas3->id,
                    'school_id' => $school3->id,
                    'kompetensi' => $komp,
                    'nilai' => $nilai,
                    'predikat' => KvtScore::hitungPredikat($nilai),
                    'semester' => 'ganjil',
                    'tahun_ajaran' => '2025/2026',
                    'dinilai_oleh' => $guru3->id,
                ]);
                $count++;
            }
        }

        $this->command->info("   ✅ KvtScoreSeeder: {$count} nilai KVT");
    }
}
