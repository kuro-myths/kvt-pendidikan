<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\KvtScore;
use App\Models\KvtLicense;
use App\Models\KvtEmailAccount;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ── 1. Admin KVT (Super Admin) ──
        $adminKvt = User::create([
            'name' => 'Admin Universe KVT',
            'nama' => 'Admin Universe KVT',
            'email' => 'admin@universekvt.com',
            'kvt_email' => 'universe.kvt@kvt.id',
            'password' => Hash::make('admin12345'),
            'role' => 'admin_kvt',
            'status' => 'aktif',
        ]);

        KvtEmailAccount::create([
            'user_id' => $adminKvt->id,
            'kvt_email' => 'universe.kvt@kvt.id',
            'display_name' => 'Admin Universe KVT',
        ]);

        // ── 2. Sample School 1 ──
        $school1 = School::create([
            'id' => Str::uuid()->toString(),
            'school_code' => 'kvt.1',
            'npsn' => '20100001',
            'nama_sekolah' => 'SMK Negeri 1 Jakarta',
            'alamat' => 'Jl. Budi Utomo No. 7, Jakarta Pusat',
            'kota' => 'Jakarta',
            'provinsi' => 'DKI Jakarta',
            'telepon' => '021-3456789',
            'jenjang' => 'SMK',
            'status' => 'aktif',
        ]);

        // License for school1
        KvtLicense::create([
            'school_id' => $school1->id,
            'tipe_lisensi' => 'pro',
            'berlaku_mulai' => now(),
            'berlaku_sampai' => now()->addYear(),
            'max_guru' => 30,
            'max_siswa' => 500,
            'max_kelas' => 15,
        ]);

        // Admin Sekolah 1
        $adminSekolah1 = User::create([
            'name' => 'Admin SMKN 1 Jakarta',
            'nama' => 'Admin SMKN 1 Jakarta',
            'email' => 'admin@smkn1jkt.sch.id',
            'kvt_email' => 'admin.smkn1@kvt.1',
            'password' => Hash::make('sekolah123'),
            'school_id' => $school1->id,
            'role' => 'admin_sekolah',
            'status' => 'aktif',
        ]);

        KvtEmailAccount::create([
            'user_id' => $adminSekolah1->id,
            'school_id' => $school1->id,
            'kvt_email' => 'admin.smkn1@kvt.1',
            'display_name' => 'Admin SMKN 1 Jakarta',
        ]);

        // Guru for school1
        $guru1 = User::create([
            'name' => 'Budi Santoso',
            'nama' => 'Budi Santoso',
            'email' => 'budi.s@smkn1jkt.sch.id',
            'kvt_email' => 'budi.santoso@kvt.1',
            'password' => Hash::make('guru12345'),
            'school_id' => $school1->id,
            'role' => 'guru',
            'nip' => '198501012010011001',
            'status' => 'aktif',
        ]);

        KvtEmailAccount::create([
            'user_id' => $guru1->id,
            'school_id' => $school1->id,
            'kvt_email' => 'budi.santoso@kvt.1',
            'display_name' => 'Budi Santoso',
        ]);

        $guru2 = User::create([
            'name' => 'Siti Aminah',
            'nama' => 'Siti Aminah',
            'email' => 'siti.a@smkn1jkt.sch.id',
            'kvt_email' => 'siti.aminah@kvt.1',
            'password' => Hash::make('guru12345'),
            'school_id' => $school1->id,
            'role' => 'guru',
            'nip' => '198703152011012002',
            'status' => 'aktif',
        ]);

        KvtEmailAccount::create([
            'user_id' => $guru2->id,
            'school_id' => $school1->id,
            'kvt_email' => 'siti.aminah@kvt.1',
            'display_name' => 'Siti Aminah',
        ]);

        // Siswa for school1
        $siswaNames = [
            ['Rizki Pratama', 'rizki.pratama', '0012345001'],
            ['Dewi Lestari', 'dewi.lestari', '0012345002'],
            ['Ahmad Fauzan', 'ahmad.fauzan', '0012345003'],
            ['Maya Sari', 'maya.sari', '0012345004'],
            ['Dimas Aditya', 'dimas.aditya', '0012345005'],
        ];

        $students1 = [];
        foreach ($siswaNames as [$nama, $username, $nisn]) {
            $s = User::create([
                'name' => $nama,
                'nama' => $nama,
                'email' => $username . '@smkn1jkt.sch.id',
                'kvt_email' => $username . '@kvt.1',
                'password' => Hash::make('siswa12345'),
                'school_id' => $school1->id,
                'role' => 'siswa',
                'nisn' => $nisn,
                'status' => 'aktif',
            ]);

            KvtEmailAccount::create([
                'user_id' => $s->id,
                'school_id' => $school1->id,
                'kvt_email' => $username . '@kvt.1',
                'display_name' => $nama,
            ]);

            $students1[] = $s;
        }

        // Classes for school1
        $kelas1 = SchoolClass::create([
            'school_id' => $school1->id,
            'nama_kelas' => 'XII RPL 1',
            'jurusan' => 'Rekayasa Perangkat Lunak',
            'tingkat' => 12,
            'tahun_ajaran' => '2025/2026',
            'semester' => 'ganjil',
            'wali_kelas_id' => $guru1->id,
        ]);
        $kelas1->students()->attach(array_map(fn($s) => $s->id, array_slice($students1, 0, 3)));

        $kelas2 = SchoolClass::create([
            'school_id' => $school1->id,
            'nama_kelas' => 'XI TKJ 2',
            'jurusan' => 'Teknik Komputer Jaringan',
            'tingkat' => 11,
            'tahun_ajaran' => '2025/2026',
            'semester' => 'ganjil',
            'wali_kelas_id' => $guru2->id,
        ]);
        $kelas2->students()->attach(array_map(fn($s) => $s->id, array_slice($students1, 2, 3)));

        // KVT Scores
        $kompetensiList = ['Pemrograman Web', 'Basis Data', 'Pemrograman Berorientasi Objek', 'Administrasi Server', 'Keamanan Jaringan'];

        foreach ($students1 as $i => $student) {
            foreach (array_slice($kompetensiList, 0, 3) as $komp) {
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
            }
        }

        // ── 3. Sample School 2 (pending) ──
        $school2 = School::create([
            'id' => Str::uuid()->toString(),
            'school_code' => 'kvt.2',
            'npsn' => '20200002',
            'nama_sekolah' => 'SMK Negeri 3 Bandung',
            'alamat' => 'Jl. Pajajaran No. 92, Bandung',
            'kota' => 'Bandung',
            'provinsi' => 'Jawa Barat',
            'telepon' => '022-7654321',
            'jenjang' => 'SMK',
            'status' => 'pending',
        ]);

        $adminSekolah2 = User::create([
            'name' => 'Admin SMKN 3 Bandung',
            'nama' => 'Admin SMKN 3 Bandung',
            'email' => 'admin@smkn3bdg.sch.id',
            'kvt_email' => 'admin.smkn3@kvt.2',
            'password' => Hash::make('sekolah123'),
            'school_id' => $school2->id,
            'role' => 'admin_sekolah',
            'status' => 'pending',
        ]);

        KvtEmailAccount::create([
            'user_id' => $adminSekolah2->id,
            'school_id' => $school2->id,
            'kvt_email' => 'admin.smkn3@kvt.2',
            'display_name' => 'Admin SMKN 3 Bandung',
        ]);

        $this->command->info('✅ Seeder selesai!');
        $this->command->info('');
        $this->command->info('🔑 Login credentials:');
        $this->command->info('   Admin KVT    : universe.kvt@kvt.id     / admin12345');
        $this->command->info('   Admin Sekolah: admin.smkn1@kvt.1       / sekolah123');
        $this->command->info('   Guru         : budi.santoso@kvt.1      / guru12345');
        $this->command->info('   Siswa        : rizki.pratama@kvt.1     / siswa12345');
    }
}
