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
    ) {}

    /**
     * Menyimpan task baru ke dalam workspace
     */
    public function store(StoreTaskRequest $request, int $teamId)
    {
        // Otorisasi: Pastikan user login punya akses ke workspace ini
        if (!$this->teamRepo->isAccessibleByUser($teamId, Auth::id())) {
            abort(403, 'Anda tidak memiliki akses ke workspace ini.');
        }

        // Jalankan Action pembuatan task
        $this->createTaskAction->execute($teamId, Auth::id(), $request->validated());

        return back()->with('success', 'Task baru berhasil ditambahkan!');
    }

    /**
     * Memperbarui data task atau status task
     */
    public function update(UpdateTaskRequest $request, int $teamId, int $taskId)
    {
        if (!$this->teamRepo->isAccessibleByUser($teamId, Auth::id())) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah task.');
        }

        // Jalankan Action update task
        $this->updateTaskAction->execute($taskId, Auth::id(), $request->validated());

        return back()->with('success', 'Task berhasil diperbarui!');
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
}