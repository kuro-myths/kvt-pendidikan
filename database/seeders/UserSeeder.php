<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\School;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin KVT (Super Admin) ──
        User::create([
            'name' => 'Admin Universe KVT',
            'nama' => 'Admin Universe KVT',
            'email' => 'admin@universekvt.com',
            'kvt_email' => 'universe.kvt@kvt.id',
            'password' => Hash::make('admin12345'),
            'role' => 'admin_kvt',
            'status' => 'aktif',
        ]);

        $school1 = School::where('school_code', 'kvt.1')->first();
        $school2 = School::where('school_code', 'kvt.2')->first();
        $school3 = School::where('school_code', 'kvt.3')->first();

        // ── Admin Sekolah ──
        User::create([
            'name' => 'Admin SMKN 1 Jakarta',
            'nama' => 'Admin SMKN 1 Jakarta',
            'email' => 'admin@smkn1jkt.sch.id',
            'kvt_email' => 'admin.smkn1@kvt.1',
            'password' => Hash::make('sekolah123'),
            'school_id' => $school1->id,
            'role' => 'admin_sekolah',
            'status' => 'aktif',
        ]);

        User::create([
            'name' => 'Admin SMKN 3 Bandung',
            'nama' => 'Admin SMKN 3 Bandung',
            'email' => 'admin@smkn3bdg.sch.id',
            'kvt_email' => 'admin.smkn3@kvt.2',
            'password' => Hash::make('sekolah123'),
            'school_id' => $school2->id,
            'role' => 'admin_sekolah',
            'status' => 'pending',
        ]);

        User::create([
            'name' => 'Admin SMAN 5 Surabaya',
            'nama' => 'Admin SMAN 5 Surabaya',
            'email' => 'admin@sman5sby.sch.id',
            'kvt_email' => 'admin.sman5@kvt.3',
            'password' => Hash::make('sekolah123'),
            'school_id' => $school3->id,
            'role' => 'admin_sekolah',
            'status' => 'aktif',
        ]);

        // ── Guru SMKN 1 Jakarta ──
        User::create([
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

        User::create([
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

        // ── Guru SMAN 5 Surabaya ──
        User::create([
            'name' => 'Andi Wijaya',
            'nama' => 'Andi Wijaya',
            'email' => 'andi.w@sman5sby.sch.id',
            'kvt_email' => 'andi.wijaya@kvt.3',
            'password' => Hash::make('guru12345'),
            'school_id' => $school3->id,
            'role' => 'guru',
            'nip' => '199001012015011003',
            'status' => 'aktif',
        ]);

        // ── Siswa SMKN 1 Jakarta ──
        $siswaSmkn1 = [
            ['Rizki Pratama', 'rizki.pratama', '0012345001'],
            ['Dewi Lestari', 'dewi.lestari', '0012345002'],
            ['Ahmad Fauzan', 'ahmad.fauzan', '0012345003'],
            ['Maya Sari', 'maya.sari', '0012345004'],
            ['Dimas Aditya', 'dimas.aditya', '0012345005'],
        ];

        foreach ($siswaSmkn1 as [$nama, $username, $nisn]) {
            User::create([
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
        }

        // ── Siswa SMAN 5 Surabaya ──
        $siswaSman5 = [
            ['Fajar Nugroho', 'fajar.nugroho', '0012345006'],
            ['Putri Rahayu', 'putri.rahayu', '0012345007'],
            ['Eko Prasetyo', 'eko.prasetyo', '0012345008'],
        ];

        foreach ($siswaSman5 as [$nama, $username, $nisn]) {
            User::create([
                'name' => $nama,
                'nama' => $nama,
                'email' => $username . '@sman5sby.sch.id',
                'kvt_email' => $username . '@kvt.3',
                'password' => Hash::make('siswa12345'),
                'school_id' => $school3->id,
                'role' => 'siswa',
                'nisn' => $nisn,
                'status' => 'aktif',
            ]);
        }

        $this->command->info('   ✅ UserSeeder: 1 admin KVT + 3 admin sekolah + 3 guru + 8 siswa');
    }
}
