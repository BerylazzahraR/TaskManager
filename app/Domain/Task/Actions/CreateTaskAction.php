<?php

namespace App\Domain\Task\Actions;

use App\Repositories\Contracts\TaskRepositoryInterface;
use App\Repositories\Contracts\WorkspaceActivityRepositoryInterface;
use App\Support\Constants\TaskConstants;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CreateTaskAction
{
    public function __construct(
        protected TaskRepositoryInterface $taskRepository,
        protected WorkspaceActivityRepositoryInterface $activityRepository
    ) {}

    public function execute(int $teamId, int $actorId, array $data)
    {
        return DB::transaction(function () use ($teamId, $actorId, $data) {
            // Setup data default
            $data['team_id'] = $teamId;
            $data['created_by'] = $actorId;
            $data['code'] = 'TSK-' . strtoupper(Str::random(6)); // Generate kode unik
            $data['slug'] = Str::slug($data['title']) . '-' . uniqid();
            
            if (empty($data['status'])) $data['status'] = TaskConstants::defaultStatus();
            if (empty($data['priority'])) $data['priority'] = TaskConstants::defaultPriority();

            // Simpan Task
            $task = $this->taskRepository->create($data);

            // Catat activity log
            $this->activityRepository->recordTaskCreated($task->id, $actorId);

            // Kalau pas bikin langsung di-assign ke orang, catat juga log assignment-nya
            if (!empty($data['assigned_to'])) {
                $this->activityRepository->recordTaskAssigned($task->id, $actorId, null, $data['assigned_to']);
            }

            return $task;
        });
    }
}