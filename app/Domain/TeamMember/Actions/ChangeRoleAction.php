<?php

namespace App\Domain\TeamMember\Actions;

use App\Repositories\Contracts\TeamMemberRepositoryInterface;
use App\Repositories\Contracts\WorkspaceActivityRepositoryInterface;
use App\Support\Constants\WorkspaceActivityConstants;

class ChangeRoleAction
{
    public function __construct(
        protected TeamMemberRepositoryInterface $teamMemberRepository,
        protected WorkspaceActivityRepositoryInterface $activityRepository
    ) {}

    public function execute(int $teamId, int $actorId, int $targetUserId, string $newRole)
    {
        $member = $this->teamMemberRepository->changeRole($teamId, $targetUserId, $newRole);

        // Catat activity log
        $this->activityRepository->create([
            'team_id' => $teamId,
            'actor_id' => $actorId,
            'action' => WorkspaceActivityConstants::ACTION_ROLE_CHANGED,
            'subject_type' => 'member',
            'subject_id' => $targetUserId,
            'description' => "Role user {$targetUserId} diubah menjadi {$newRole}.",
        ]);

        return $member;
    }
}