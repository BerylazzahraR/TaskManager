<?php

namespace App\Domain\Team\Actions;

use App\Repositories\Contracts\TeamRepositoryInterface;
use App\Repositories\Contracts\WorkspaceActivityRepositoryInterface;
use App\Support\Constants\WorkspaceActivityConstants;

class DeleteAction
{
    public function __construct(
        protected TeamRepositoryInterface $teamRepository,
        protected WorkspaceActivityRepositoryInterface $activityRepository
    ) {}

    public function execute(int $teamId, int $actorId)
    {
        // 1. Catat activity team_deleted DULU sebelum row-nya beneran di-soft delete
        $this->activityRepository->create([
            'team_id' => $teamId,
            'actor_id' => $actorId,
            'action' => WorkspaceActivityConstants::ACTION_TEAM_DELETED,
            'description' => "Workspace was deleted.",
        ]);

        // 2. Soft delete workspace
        return $this->teamRepository->delete($teamId);
    }
}