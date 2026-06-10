<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TeamArchiveController;
use App\Http\Controllers\TeamMemberController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profil bawaan Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Custom routes untuk pengarsipan dan restore team Workspace
    Route::post('/teams/{team}/archive', [TeamArchiveController::class, 'store'])->name('teams.archive');
    Route::post('/teams/{team}/restore', [TeamArchiveController::class, 'restore'])->name('teams.restore');

    // Resource Route untuk Team Member Management (Add, Change Role, Remove)
    Route::post('/teams/{team}/members', [App\Http\Controllers\TeamMemberController::class, 'store'])->name('teams.members.store');
    Route::put('/teams/{team}/members/{user}', [App\Http\Controllers\TeamMemberController::class, 'update'])->name('teams.members.update');
    Route::delete('/teams/{team}/members/{user}', [App\Http\Controllers\TeamMemberController::class, 'destroy'])->name('teams.members.destroy');

    // Resource Route untuk Task CRUD
    Route::get('/teams/{team_slug}/tasks/create', [App\Http\Controllers\TaskController::class, 'create'])->name('teams.tasks.create'); // <- TAMBAH INI
    Route::post('/teams/{team}/tasks', [App\Http\Controllers\TaskController::class, 'store'])->name('teams.tasks.store');
    Route::post('/teams/{team}/tasks', [App\Http\Controllers\TaskController::class, 'store'])->name('teams.tasks.store');
    Route::get('/teams/{team}/tasks/{task}/edit', [App\Http\Controllers\TaskController::class, 'edit'])->name('teams.tasks.edit');
    Route::put('/teams/{team}/tasks/{task}', [App\Http\Controllers\TaskController::class, 'update'])->name('teams.tasks.update');
    Route::delete('/teams/{team}/tasks/{task}', [App\Http\Controllers\TaskController::class, 'destroy'])->name('teams.tasks.destroy');
    Route::post('/teams/{team}/tasks/{task}/comments', [App\Http\Controllers\TaskCommentController::class, 'store'])->name('teams.tasks.comments.store');
    // Tambahin baris ini bro:
    Route::get('/teams/{team}/tasks/{task}', [App\Http\Controllers\TaskController::class, 'show'])->name('teams.tasks.show');

    Route::get('/teams/{team_slug}/board', [App\Http\Controllers\TaskController::class, 'board'])->name('teams.tasks.board');
    Route::patch('/teams/{team}/tasks/{task}/status', [App\Http\Controllers\TaskController::class, 'updateStatus'])->name('teams.tasks.update-status');
    // Standard Resource Route untuk Team CRUD
    Route::resource('teams', TeamController::class)->parameters([
        'teams' => 'team' 
    ]);
    Route::patch('/notifications/{notification}/read', function (\App\Models\Notification $notification) {
    // Pastiin cuma yang punya notif yang bisa nge-read
    if ($notification->user_id == auth()->id()) {
        $notification->update([
            'read_at' => now(), 
            'status' => 'read'
        ]);
    }
    return back();
})->name('notifications.read');
});

require __DIR__.'/auth.php';