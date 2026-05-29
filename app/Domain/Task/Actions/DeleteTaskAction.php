<?php

namespace App\Domain\Task\Actions;

use App\Repositories\Contracts\TaskRepositoryInterface;
use App\Repositories\Contracts\WorkspaceActivityRepositoryInterface;
use App\Support\Constants\WorkspaceActivityConstants;

class DeleteTaskAction
{
    public function __construct(
        protected TaskRepositoryInterface $taskRepository,
        protected WorkspaceActivityRepositoryInterface $activityRepository
    ) {}

    public function execute(int $taskId, int $actorId)
    {
        $task = $this->taskRepository->find($taskId);
        
        $this->activityRepository->create([
            'team_id' => $task->team_id,
            'task_id' => $taskId,
            'actor_id' => $actorId,
            'action' => WorkspaceActivityConstants::ACTION_TASK_DELETED,
            'subject_type' => 'task',
            'subject_id' => $taskId,
            'description' => "Task {$task->code} was deleted.",
        ]);

        return $this->taskRepository->delete($taskId);
    }
}