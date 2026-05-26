<?php

namespace App\Domain\TeamMember\Actions;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\TeamMemberRepositoryInterface;
use App\Repositories\Contracts\WorkspaceActivityRepositoryInterface;
use App\Support\Constants\TeamMemberConstants;
use Exception;

class AddMemberAction
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected TeamMemberRepositoryInterface $teamMemberRepository,
        protected WorkspaceActivityRepositoryInterface $activityRepository
    ) {}

    public function execute(int $teamId, int $actorId, array $data)
    {
        // 1. Cari user berdasarkan email
        $user = $this->userRepository->findByEmail($data['email']);

        // 2. Cek apakah user sudah jadi member di workspace ini
        if ($this->teamMemberRepository->isActiveMember($teamId, $user->id)) {
            throw new Exception('User ini sudah menjadi anggota aktif di workspace.');
        }

        // 3. Tambahkan ke tim
        $member = $this->teamMemberRepository->create([
            'team_id' => $teamId,
            'user_id' => $user->id,
            'role' => TeamMemberConstants::ROLE_MEMBER, // Default role
            'status' => TeamMemberConstants::STATUS_ACTIVE,
            'joined_at' => now(),
        ]);

        // 4. Catat ke activity log
        $this->activityRepository->recordMemberAdded($teamId, $actorId, $user->id);

        return $member;
    }
}