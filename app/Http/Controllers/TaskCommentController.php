<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskComment;
use App\Repositories\Contracts\WorkspaceActivityRepositoryInterface;
use App\Support\Constants\WorkspaceActivityConstants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskCommentController extends Controller
{
    public function store(Request $request, int $teamId, int $taskId, WorkspaceActivityRepositoryInterface $activityRepo)
    {
        // Validasi input disesuaikan dengan nama kolom lo (body)
        $request->validate([
            'body' => 'required|string|max:1000'
        ]);

        $task = Task::findOrFail($taskId);

        // Simpan komentar
        TaskComment::create([
            'task_id' => $task->id,
            'user_id' => Auth::id(),
            'body' => $request->body
        ]);

        // Catat ke Activity Timeline Workspace
        $activityRepo->create([
            'team_id' => $teamId,
            'actor_id' => Auth::id(),
            'action' => WorkspaceActivityConstants::ACTION_COMMENT_ADDED,
            'subject_type' => 'task',
            'subject_id' => $task->id,
            'description' => "Menambahkan komentar pada task {$task->code}.",
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }
}