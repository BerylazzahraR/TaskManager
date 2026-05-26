<?php

namespace App\Domain\Team\Actions;

use App\Repositories\Contracts\TeamRepositoryInterface;
use App\Repositories\Contracts\WorkspaceActivityRepositoryInterface;
use App\Support\Constants\WorkspaceActivityConstants;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UpdateAction
{
    public function __construct(
        protected TeamRepositoryInterface $teamRepository,
        protected WorkspaceActivityRepositoryInterface $activityRepository
    ) {}

    public function execute(int $teamId, int $actorId, array $data)
    {
        return DB::transaction(function () use ($teamId, $actorId, $data) {
            $team = $this->teamRepository->find($teamId);
            $beforeData = $team->toArray();

            // Generate ulang slug jika nama berubah
            if (isset($data['name']) && $data['name'] !== $team->name) {
                $data['slug'] = Str::slug($data['name']) . '-' . uniqid();
            }

            // Update nama, slug, deskripsi, dll
            $updatedTeam = $this->teamRepository->update($teamId, $data);

            // Catat activity team_updated dengan payload sebelum dan sesudah perubahan
            $this->activityRepository->create([
                'team_id' => $team->id,
                'actor_id' => $actorId,
                'action' => WorkspaceActivityConstants::ACTION_TEAM_UPDATED,
                'description' => "Workspace settings were updated.",
                'before_data' => $beforeData,
                'after_data' => $updatedTeam->toArray(),
            ]);

            return $updatedTeam;
        });
    }
}