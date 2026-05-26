<?php

namespace Database\Seeders;

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $tasks = [
            [
                'title' => 'Riset Database Transportasi Berkelanjutan (SDG 11.2)',
                'status' => 'todo',
                'priority' => 'high',
            ],
            [
                'title' => 'Implementasi Toggle Status Document Definition',
                'status' => 'in_progress',
                'priority' => 'medium',
            ],
            [
                'title' => 'Persiapan Ticketing & Usher Sounds of Downtown 2025',
                'status' => 'done',
                'priority' => 'low',
            ]
        ];

        foreach ($tasks as $index => $task) {
            Task::create([
                'team_id' => 1,
                'code' => 'TSK-00' . ($index + 1),
                'title' => $task['title'],
                'slug' => Str::slug($task['title']),
                'description' => 'Deskripsi detail untuk task ' . $task['title'],
                'created_by' => 1,
                'assigned_to' => 1, // Di-assign ke akun utama
                'status' => $task['status'],
                'priority' => $task['priority'],
                'deadline_at' => now()->addDays(rand(1, 7)),
                'completed_at' => $task['status'] === 'done' ? now() : null,
                'position' => $index + 1,
            ]);
        }
    }
}
