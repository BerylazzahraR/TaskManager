<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    public function run(): void
    {
        TeamMember::create([
            'team_id' => 1,
            'user_id' => 1, // Akun Beryl
            'role' => 'owner',
            'status' => 'active',
            'joined_at' => now(),
        ]);
        
        // Memasukkan user factory lain sebagai member biasa
        for ($i = 2; $i <= 4; $i++) {
            TeamMember::create([
                'team_id' => 1,
                'user_id' => $i,
                'role' => 'member',
                'status' => 'active',
                'invited_by' => 1,
                'joined_at' => now(),
            ]);
        }
    }
}