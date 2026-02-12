<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Urutan seeder HARUS diperhatikan karena ada dependency:
     * 1. SchoolSeeder   → buat sekolah + lisensi
     * 2. UserSeeder     → buat user (butuh school_id)
     * 3. KvtEmailSeeder → buat email KVT (butuh user_id + school_id)
     * 4. ClassSeeder    → buat kelas + assign siswa (butuh user + school)
     * 5. KvtScoreSeeder → buat nilai (butuh student + class + school)
     * 6. EduToolSeeder  → katalog tools edukasi
     * 7. UserEduToolSeeder → contoh klaim tools (butuh user + edu_tools)
     */
    public function run(): void
    {
        $this->command->info('');
        $this->command->info('🚀 Memulai seeding Universe KVT...');
        $this->command->info('');

        $this->call([
            SchoolSeeder::class,
            UserSeeder::class,
            KvtEmailSeeder::class,
            ClassSeeder::class,
            KvtScoreSeeder::class,
            EduToolSeeder::class,
            UserEduToolSeeder::class,
        ]);

        $this->command->info('');
        $this->command->info('══════════════════════════════════════════');
        $this->command->info('✅ Semua seeder selesai!');
        $this->command->info('══════════════════════════════════════════');
        $this->command->info('');
        $this->command->info('🔑 Login credentials:');
        $this->command->info('   Admin KVT      : universe.kvt@kvt.id     / admin12345');
        $this->command->info('   Admin Sekolah 1 : admin.smkn1@kvt.1       / sekolah123');
        $this->command->info('   Admin Sekolah 3 : admin.sman5@kvt.3       / sekolah123');
        $this->command->info('   Guru            : budi.santoso@kvt.1      / guru12345');
        $this->command->info('   Siswa           : rizki.pratama@kvt.1     / siswa12345');
        $this->command->info('');
    }
}
