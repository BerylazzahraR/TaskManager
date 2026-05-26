<?php

namespace App\Domain\Team\Actions;

use App\Repositories\Contracts\TeamRepositoryInterface;
use App\Repositories\Contracts\WorkspaceActivityRepositoryInterface;
use App\Support\Constants\WorkspaceActivityConstants;

class ArchiveAction
{
    public function __construct(
        protected TeamRepositoryInterface $teamRepository,
        protected WorkspaceActivityRepositoryInterface $activityRepository
    ) {}

    public function execute(int $teamId, int $actorId)
    {
        $team = $this->teamRepository->archive($teamId); // Memanggil method archive di Repository

        $this->activityRepository->create([
            'team_id' => $teamId,
            'actor_id' => $actorId,
            'action' => WorkspaceActivityConstants::ACTION_TEAM_UPDATED,
            'description' => "Workspace was archived.",
        ]);

        return $team;
    }
}