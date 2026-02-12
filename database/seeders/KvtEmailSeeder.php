<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\KvtEmailAccount;
use App\Models\School;
use Illuminate\Database\Seeder;

class KvtEmailSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua user yang punya kvt_email
        $users = User::whereNotNull('kvt_email')->get();

        foreach ($users as $user) {
            KvtEmailAccount::create([
                'user_id' => $user->id,
                'school_id' => $user->school_id,
                'kvt_email' => $user->kvt_email,
                'display_name' => $user->nama,
            ]);
        }

        $this->command->info("   ✅ KvtEmailSeeder: {$users->count()} akun email KVT");
    }
}
