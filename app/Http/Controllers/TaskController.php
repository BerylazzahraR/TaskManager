<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Domain\Task\Actions\CreateTaskAction;
use App\Domain\Task\Actions\UpdateTaskAction;
use App\Domain\Task\Actions\DeleteTaskAction;
use App\Repositories\Contracts\TeamRepositoryInterface;
use App\Repositories\Contracts\TaskRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function __construct(
        protected TeamRepositoryInterface $teamRepo,
        protected TaskRepositoryInterface $taskRepo,
        protected CreateTaskAction $createTaskAction,
        protected UpdateTaskAction $updateTaskAction,
        protected DeleteTaskAction $deleteTaskAction
    ) {
    }

    /**
     * Menyimpan task baru ke dalam workspace
     */
    public function store(StoreTaskRequest $request, int $teamId)
    {
        if (!$this->teamRepo->isAccessibleByUser($teamId, Auth::id())) {
            abort(403, 'Anda tidak memiliki akses ke workspace ini.');
        }
        $task = $this->createTaskAction->execute($teamId, Auth::id(), $request->validated());
        return redirect()->route('teams.tasks.show', [$teamId, $task->id])
            ->with('success', 'Task baru berhasil ditambahkan!');
    }
    public function create(string $slug, \App\Domain\Team\Queries\TeamQuery $teamQuery)
    {
        $team = $teamQuery->getBySlug($slug);

        // Cek Otorisasi (Hanya anggota yang bisa buat task)
        if ($team->owner_id !== \Illuminate\Support\Facades\Auth::id() && !$team->users()->where('users.id', \Illuminate\Support\Facades\Auth::id())->exists()) {
            abort(403, 'Anda tidak memiliki akses ke workspace ini.');
        }

        // Ambil daftar member buat dropdown "Assignee"
        $members = $teamQuery->getMembers($team->id);

        return view('team.tasks.create', compact('team', 'members'));
    }

    /**
     * Memperbarui data task atau status task
     */
    public function update(UpdateTaskRequest $request, int $teamId, int $taskId)
    {
        if (!$this->teamRepo->isAccessibleByUser($teamId, Auth::id())) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah task.');
        }
        $this->updateTaskAction->execute($taskId, Auth::id(), $request->validated());
        return redirect()->route('teams.tasks.show', [$teamId, $taskId])
            ->with('success', 'Task berhasil diperbarui!');
    }
    /**
     * Menampilkan form edit task
     */
    public function edit(int $teamId, int $taskId)
    {
        // Otorisasi
        if (!$this->teamRepo->isAccessibleByUser($teamId, Auth::id())) {
            abort(403, 'Anda tidak memiliki akses ke workspace ini.');
        }

        $team = $this->teamRepo->find($teamId);
        $task = $this->taskRepo->find($taskId);
        $members = $this->teamRepo->members($teamId);

        return view('team.tasks.edit', compact('team', 'task', 'members'));
    }

    /**
     * Menghapus task (Soft Delete)
     */
    public function destroy(int $teamId, int $taskId)
    {
        if (!$this->teamRepo->isAccessibleByUser($teamId, Auth::id())) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus task.');
        }

        // Jalankan Action penghapusan task
        $this->deleteTaskAction->execute($taskId, Auth::id());

        return back()->with('success', 'Task berhasil dihapus.');
    }

    /**
     * Menampilkan halaman Kanban Board (Drag & Drop)
     */
    public function board(string $slug, \App\Domain\Team\Queries\TeamQuery $teamQuery)
    {
        $team = $teamQuery->getBySlug($slug);

        // Otorisasi Akses
        if ($team->owner_id !== Auth::id() && !$team->users()->where('users.id', Auth::id())->exists()) {
            abort(403, 'Anda tidak memiliki akses ke workspace ini.');
        }

        // Tarik semua task dan kelompokkan berdasarkan statusnya
        $tasks = $teamQuery->getTasks($team->id);
        $todoTasks = $tasks->where('status', 'todo');
        $inProgressTasks = $tasks->where('status', 'in_progress');
        $doneTasks = $tasks->where('status', 'done');

        return view('team.tasks.board', compact('team', 'todoTasks', 'inProgressTasks', 'doneTasks'));
    }

    /**
     * Update status via AJAX saat drag & drop selesai
     */
    public function updateStatus(Request $request, int $teamId, int $taskId, \App\Repositories\Contracts\WorkspaceActivityRepositoryInterface $activityRepo)
    {
        $request->validate(['status' => 'required|in:todo,in_progress,done']);

        $task = \App\Models\Task::where('team_id', $teamId)->findOrFail($taskId);
        $oldStatus = $task->status;
        $newStatus = $request->status;

        if ($oldStatus !== $newStatus) {
            $task->update(['status' => $newStatus]);

            // Catat ke Activity Timeline
            $activityRepo->create([
                'team_id' => $teamId,
                'actor_id' => Auth::id(),
                'action' => 'updated_task_status',
                'subject_type' => 'task',
                'subject_id' => $task->id,
                'description' => "Memindahkan task {$task->title} ke kolom " . strtoupper($newStatus),
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Status updated']);
    }
    public function show(int $teamId, int $taskId)
    {
        $team = \App\Models\Team::findOrFail($teamId);
        $task = \App\Models\Task::with(['assignee', 'comments.user'])->where('team_id', $teamId)->findOrFail($taskId);

        return view('team.tasks.show', compact('team', 'task'));
    }
}