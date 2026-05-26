<?php

namespace App\Domain\Team\Actions;

use App\Repositories\Contracts\TeamRepositoryInterface;
use App\Repositories\Contracts\TeamMemberRepositoryInterface;
use App\Repositories\Contracts\WorkspaceActivityRepositoryInterface;
use App\Support\Constants\TeamMemberConstants;
use App\Support\Constants\WorkspaceActivityConstants;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CreateAction
{
    public function __construct(
        protected TeamRepositoryInterface $teamRepository,
        protected TeamMemberRepositoryInterface $teamMemberRepository,
        protected WorkspaceActivityRepositoryInterface $activityRepository
    ) {}

    public function execute(int $creatorId, array $data)
    {
        return DB::transaction(function () use ($creatorId, $data) {
            // 1. Generate slug dari nama workspace
            $data['owner_id'] = $creatorId;
            $data['slug'] = Str::slug($data['name']) . '-' . uniqid(); 

            // 2. Simpan workspace ke database
            $team = $this->teamRepository->create($data);

            // 3. Set pembuat sebagai owner aktif di tabel pivot team_members
            $this->teamMemberRepository->create([
                'team_id' => $team->id,
                'user_id' => $creatorId,
                'role' => TeamMemberConstants::ROLE_OWNER,
                'status' => TeamMemberConstants::STATUS_ACTIVE,
                'joined_at' => now(),
            ]);

            // 4. Catat activity team_created
            $this->activityRepository->create([
                'team_id' => $team->id,
                'actor_id' => $creatorId,
                'action' => WorkspaceActivityConstants::ACTION_TEAM_CREATED,
                'description' => "Workspace '{$team->name}' was created.",
            ]);

            return $team;
        });
    }
}