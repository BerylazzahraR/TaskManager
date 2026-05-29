<?php

namespace App\Repositories\Eloquent;

use App\Models\TeamMember;
use App\Support\Constants\TeamMemberConstants;
use App\Repositories\Contracts\TeamMemberRepositoryInterface;

class TeamMemberRepository extends BaseRepository implements TeamMemberRepositoryInterface
{
    public function __construct(TeamMember $model)
    {
        parent::__construct($model);
    }

    public function byTeam($teamId)
    {
        return $this->model->where('team_id', $teamId)->get();
    }

    public function byUser($userId)
    {
        return $this->model->where('user_id', $userId)->get();
    }

    public function active($teamId)
    {
        return $this->model->where('team_id', $teamId)
            ->where('status', TeamMemberConstants::STATUS_ACTIVE)
            ->get();
    }

    public function findMember($teamId, $userId)
    {
        return $this->model->where('team_id', $teamId)->where('user_id', $userId)->first();
    }

    public function isActiveMember($teamId, $userId)
    {
        $member = $this->findMember($teamId, $userId);
        return $member && $member->status === TeamMemberConstants::STATUS_ACTIVE;
    }

    public function isOwner($teamId, $userId)
    {
        $member = $this->findMember($teamId, $userId);
        return $member && $member->role === TeamMemberConstants::ROLE_OWNER;
    }

    public function isAdminOrOwner($teamId, $userId)
    {
        $member = $this->findMember($teamId, $userId);
        return $member && in_array($member->role, [TeamMemberConstants::ROLE_OWNER, TeamMemberConstants::ROLE_ADMIN]);
    }

    public function changeRole($teamId, $userId, $role)
    {
        $member = $this->findMember($teamId, $userId);
        if ($member) {
            $member->update(['role' => $role]);
        }
        return $member;
    }

    public function removeMember($teamId, $userId)
    {
        $member = $this->findMember($teamId, $userId);
        if ($member) {
            // Hard delete agar data langsung hilang dari tabel dan tampilan UI
            $member->delete();
        }
        return $member;
    }

    public function countOwners($teamId)
    {
        return $this->model->where('team_id', $teamId)
            ->where('role', TeamMemberConstants::ROLE_OWNER)
            ->where('status', TeamMemberConstants::STATUS_ACTIVE)
            ->count();
    }
}