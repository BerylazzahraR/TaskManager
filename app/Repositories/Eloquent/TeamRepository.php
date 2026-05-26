<?php

namespace App\Repositories\Eloquent;

use App\Models\Team;
use App\Support\Constants\TeamConstants;
use App\Repositories\Contracts\TeamRepositoryInterface;

class TeamRepository extends BaseRepository implements TeamRepositoryInterface
{
    public function __construct(Team $model)
    {
        parent::__construct($model);
    }

    public function findBySlug($slug)
    {
        return $this->model->where('slug', $slug)->firstOrFail();
    }

    public function archive($id)
    {
        return $this->update($id, ['status' => TeamConstants::STATUS_ARCHIVED]);
    }

    public function restore($id)
    {
        $team = $this->model->withTrashed()->findOrFail($id);
        $team->restore();
        $team->update(['status' => TeamConstants::STATUS_ACTIVE]);
        return $team;
    }

    public function byOwner($ownerId)
    {
        return $this->model->where('owner_id', $ownerId)->get();
    }

    public function byUser($userId)
    {
        return $this->model->whereHas('users', function ($query) use ($userId) {
            $query->where('users.id', $userId);
        })->get();
    }

    public function activeByUser($userId)
    {
        return $this->model->where('status', TeamConstants::STATUS_ACTIVE)
                           ->whereHas('users', function ($query) use ($userId) {
                               $query->where('users.id', $userId);
                           })->get();
    }

    public function members($teamId)
    {
        return $this->find($teamId)->users;
    }

    public function tasks($teamId)
    {
        return $this->find($teamId)->tasks;
    }

    public function dashboard($teamId)
    {
        return $this->find($teamId)->tasks()
                    ->selectRaw('status, count(*) as count')
                    ->groupBy('status')
                    ->get();
    }

    public function isAccessibleByUser($teamId, $userId)
    {
        $team = $this->find($teamId);
        return $team->owner_id === $userId || $team->users()->where('users.id', $userId)->exists();
    }
}