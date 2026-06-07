<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\Team;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // 1. Statistik Singkat Task Milik User
        $totalTasks = Task::where('assigned_to', $userId)->count();
        $completedTasks = Task::where('assigned_to', $userId)->where('status', 'done')->count();
        $pendingTasks = $totalTasks - $completedTasks;

        // --- TAMBAHIN INI: Hitung Task Terlambat ---
        $overdueTasks = Task::where('assigned_to', $userId)
            ->where('status', '!=', 'done')
            ->whereNotNull('deadline_at')
            ->whereDate('deadline_at', '<', now())
            ->count();

        // 2. Ambil Task yang belum selesai & diurutkan dari deadline terdekat
        $myTasks = Task::with('team')
            ->where('assigned_to', $userId)
            ->where('status', '!=', 'done')
            ->orderByRaw('deadline_at IS NULL, deadline_at ASC')
            ->take(10)
            ->get();

        // 3. Ambil Workspace di mana user menjadi Owner atau Member aktif
        $myWorkspaces = Team::where('owner_id', $userId)
            ->orWhereHas('users', function ($query) use ($userId) {
                $query->where('users.id', $userId)
                    ->where('team_members.status', 'active');
            })
            ->where('status', 'active')
            ->distinct()
            ->get();

        
        return view('dashboard', compact('totalTasks', 'completedTasks', 'pendingTasks', 'overdueTasks', 'myTasks', 'myWorkspaces'));
    }
}