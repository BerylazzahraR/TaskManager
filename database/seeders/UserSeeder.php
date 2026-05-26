<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Beryl A.Md.Kom.',
            'email' => 'beryl@student.uns.ac.id',
            'password' => Hash::make('password'),
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // Bikin beberapa user dummy tambahan buat ngetes fitur assign task
        User::factory()->count(3)->create();
    }
}