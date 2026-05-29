<?php

namespace App\Domain\Task\Actions;

use App\Repositories\Contracts\TaskRepositoryInterface;
use App\Repositories\Contracts\WorkspaceActivityRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UpdateTaskAction
{
    public function __construct(
        protected TaskRepositoryInterface $taskRepository,
        protected WorkspaceActivityRepositoryInterface $activityRepository
    ) {}

    public function execute(int $taskId, int $actorId, array $data)
    {
        return DB::transaction(function () use ($taskId, $actorId, $data) {
            $oldTask = $this->taskRepository->find($taskId);
            $oldData = $oldTask->toArray();

            // Update Task-nya
            $newTask = $this->taskRepository->update($taskId, $data);

            // Cek kalau status berubah
            if (isset($data['status']) && $data['status'] !== $oldTask->status) {
                $this->activityRepository->recordStatusChanged($taskId, $actorId, $oldTask->status, $data['status']);
            }

            // Cek kalau orang yang ditugaskan (assignee) berubah
            if (isset($data['assigned_to']) && $data['assigned_to'] !== $oldTask->assigned_to) {
                $this->activityRepository->recordTaskAssigned($taskId, $actorId, $oldTask->assigned_to, $data['assigned_to']);
            }

            // Catat general update
            $this->activityRepository->recordTaskUpdated($taskId, $actorId, $oldData, $newTask->toArray());

            return $newTask;
        });
    }
}