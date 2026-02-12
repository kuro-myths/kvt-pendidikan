<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\EduTool;
use App\Models\UserEduTool;
use Illuminate\Database\Seeder;

class UserEduToolSeeder extends Seeder
{
    public function run(): void
    {
        // Beri beberapa siswa contoh klaim edu tools
        $github = EduTool::where('slug', 'github-education')->first();
        $figma = EduTool::where('slug', 'figma-education')->first();
        $notion = EduTool::where('slug', 'notion-education')->first();
        $copilot = EduTool::where('slug', 'github-copilot')->first();
        $jetbrains = EduTool::where('slug', 'jetbrains-student')->first();

        // Rizki Pratama — power user, klaim banyak tools
        $rizki = User::where('kvt_email', 'rizki.pratama@kvt.1')->first();
        if ($rizki && $github) {
            UserEduTool::create([
                'user_id' => $rizki->id,
                'edu_tool_id' => $github->id,
                'kvt_email_used' => $rizki->kvt_email,
                'status' => 'aktif',
                'claimed_at' => now()->subDays(30),
                'expires_at' => now()->addYear(),
            ]);
        }
        if ($rizki && $copilot) {
            UserEduTool::create([
                'user_id' => $rizki->id,
                'edu_tool_id' => $copilot->id,
                'kvt_email_used' => $rizki->kvt_email,
                'status' => 'aktif',
                'claimed_at' => now()->subDays(28),
                'expires_at' => now()->addYear(),
            ]);
        }
        if ($rizki && $figma) {
            UserEduTool::create([
                'user_id' => $rizki->id,
                'edu_tool_id' => $figma->id,
                'kvt_email_used' => $rizki->kvt_email,
                'status' => 'aktif',
                'claimed_at' => now()->subDays(20),
                'expires_at' => now()->addYear(),
            ]);
        }
        if ($rizki && $jetbrains) {
            UserEduTool::create([
                'user_id' => $rizki->id,
                'edu_tool_id' => $jetbrains->id,
                'kvt_email_used' => $rizki->kvt_email,
                'status' => 'aktif',
                'claimed_at' => now()->subDays(15),
                'expires_at' => now()->addYear(),
            ]);
        }

        // Dewi Lestari — baru mulai, 1 tool pending
        $dewi = User::where('kvt_email', 'dewi.lestari@kvt.1')->first();
        if ($dewi && $github) {
            UserEduTool::create([
                'user_id' => $dewi->id,
                'edu_tool_id' => $github->id,
                'kvt_email_used' => $dewi->kvt_email,
                'status' => 'pending',
                'claimed_at' => now()->subDays(2),
            ]);
        }
        if ($dewi && $notion) {
            UserEduTool::create([
                'user_id' => $dewi->id,
                'edu_tool_id' => $notion->id,
                'kvt_email_used' => $dewi->kvt_email,
                'status' => 'aktif',
                'claimed_at' => now()->subDays(10),
                'expires_at' => now()->addYear(),
            ]);
        }

        // Ahmad Fauzan — github aktif
        $ahmad = User::where('kvt_email', 'ahmad.fauzan@kvt.1')->first();
        if ($ahmad && $github) {
            UserEduTool::create([
                'user_id' => $ahmad->id,
                'edu_tool_id' => $github->id,
                'kvt_email_used' => $ahmad->kvt_email,
                'status' => 'aktif',
                'claimed_at' => now()->subDays(45),
                'expires_at' => now()->addYear(),
            ]);
        }

        $this->command->info('   ✅ UserEduToolSeeder: contoh klaim edu tools');
    }
}
