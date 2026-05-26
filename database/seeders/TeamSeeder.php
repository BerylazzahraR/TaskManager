<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        $name = 'Dev Team for himatif';
        
        Team::create([
            'owner_id' => 1,
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => 'Workspace utama manajemen project internal.',
            'status' => 'active',
            'visibility' => 'internal',
        ]);
    }
}