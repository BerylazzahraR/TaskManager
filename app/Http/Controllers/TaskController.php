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

        // Eksekusi Action Create
        $task = $this->createTaskAction->execute($teamId, Auth::id(), $request->validated());

        // --- NOTIFIKASI ASSIGN TASK BARU ---
        // Jika form 'assigned_to' diisi dan bukan ditugaskan ke diri sendiri
        if ($request->filled('assigned_to') && $request->assigned_to != Auth::id()) {
            \App\Models\Notification::create([
                'user_id'      => $request->assigned_to,
                'team_id'      => $teamId,
                'task_id'      => $task->id,
                'triggered_by' => Auth::id(),
                'type'         => 'task_assigned',
                'channel'      => 'in_app',
                'title'        => 'Tugas Baru: ' . $task->title,
                'message'      => Auth::user()->name . ' menugaskan sebuah task kepada Anda.',
                'status'       => 'sent',
                'sent_at'      => now(),
            ]);
        }

        return redirect()->route('teams.tasks.show', [$teamId, $task->id])
            ->with('success', 'Task baru berhasil ditambahkan!');
    }

    public function create(string $slug, \App\Domain\Team\Queries\TeamQuery $teamQuery)
    {
        $team = $teamQuery->getBySlug($slug);

        // Cek Otorisasi (Hanya anggota yang bisa buat task)
        if ($team->owner_id !== Auth::id() && !$team->users()->where('users.id', Auth::id())->exists()) {
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

        // Ambil data task lama buat ngecek apakah orang yang ditugaskan (assignee) diubah
        $oldTask = \App\Models\Task::findOrFail($taskId);
        $oldAssignee = $oldTask->assigned_to;

        // Eksekusi Action Update
        $this->updateTaskAction->execute($taskId, Auth::id(), $request->validated());

        // --- NOTIFIKASI ASSIGNEE DIUBAH ---
        // Kirim notif HANYA jika orang yang ditugaskan beda dari sebelumnya dan bukan diri sendiri
        if ($request->filled('assigned_to') && $request->assigned_to != $oldAssignee && $request->assigned_to != Auth::id()) {
            \App\Models\Notification::create([
                'user_id'      => $request->assigned_to,
                'team_id'      => $teamId,
                'task_id'      => $taskId,
                'triggered_by' => Auth::id(),
                'type'         => 'task_assigned',
                'channel'      => 'in_app',
                'title'        => 'Tugas Diperbarui: ' . $oldTask->title,
                'message'      => Auth::user()->name . ' menugaskan ulang task ini kepada Anda.',
                'status'       => 'sent',
                'sent_at'      => now(),
            ]);
        }

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

        // Ambil slug team buat bahan redirect
        $team = \App\Models\Team::findOrFail($teamId);

        // Jalankan Action penghapusan task
        $this->deleteTaskAction->execute($taskId, Auth::id());

        // Perbaikan: Redirect kembali ke halaman Workspace (Biar gak 404 kalau dihapus dari halaman detail)
        return redirect()->route('teams.show', $team->slug)
            ->with('success', 'Task berhasil dihapus.');
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