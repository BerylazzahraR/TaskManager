<?php

namespace App\Domain\TeamMember\Actions;

use App\Repositories\Contracts\TeamMemberRepositoryInterface;
use App\Repositories\Contracts\WorkspaceActivityRepositoryInterface;

class RemoveMemberAction
{
    public function __construct(
        protected TeamMemberRepositoryInterface $teamMemberRepository,
        protected WorkspaceActivityRepositoryInterface $activityRepository
    ) {}

    public function execute(int $teamId, int $actorId, int $targetUserId)
    {
        // Ubah status jadi removed (Soft Remove) sesuai spesifikasi
        $member = $this->teamMemberRepository->removeMember($teamId, $targetUserId);

        // Catat activity log
        $this->activityRepository->recordMemberRemoved($teamId, $actorId, $targetUserId);

        return $member;
    }
}