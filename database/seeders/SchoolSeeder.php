<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\KvtLicense;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SchoolSeeder extends Seeder
{
    public function run(): void
    {
        // ── SMK Negeri 1 Jakarta (Aktif, Pro License) ──
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

        KvtLicense::create([
            'school_id' => $school1->id,
            'tipe_lisensi' => 'pro',
            'berlaku_mulai' => now(),
            'berlaku_sampai' => now()->addYear(),
            'max_guru' => 30,
            'max_siswa' => 500,
            'max_kelas' => 15,
        ]);

        // ── SMK Negeri 3 Bandung (Pending, No License) ──
        School::create([
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

        // ── SMA Negeri 5 Surabaya (Aktif, Basic License) ──
        $school3 = School::create([
            'id' => Str::uuid()->toString(),
            'school_code' => 'kvt.3',
            'npsn' => '20300003',
            'nama_sekolah' => 'SMA Negeri 5 Surabaya',
            'alamat' => 'Jl. Kertajaya No. 45, Surabaya',
            'kota' => 'Surabaya',
            'provinsi' => 'Jawa Timur',
            'telepon' => '031-5678901',
            'jenjang' => 'SMA',
            'status' => 'aktif',
        ]);

        KvtLicense::create([
            'school_id' => $school3->id,
            'tipe_lisensi' => 'basic',
            'berlaku_mulai' => now(),
            'berlaku_sampai' => now()->addMonths(6),
            'max_guru' => 10,
            'max_siswa' => 100,
            'max_kelas' => 5,
        ]);

        $this->command->info('   ✅ SchoolSeeder: 3 sekolah + 2 lisensi');
    }
}
