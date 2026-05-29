<?php

namespace App\Domain\Team\Queries;

use App\Repositories\Contracts\TeamRepositoryInterface;

class TeamQuery
{
    public function __construct(
        protected TeamRepositoryInterface $teamRepository
    ) {
    }

    public function getAll()
    {
        return $this->teamRepository->all();
    }

    public function getById(int $id)
    {
        return $this->teamRepository->find($id);
    }

    public function getBySlug(string $slug)
    {
        return $this->teamRepository->findBySlug($slug);
    }

    public function getByOwner(int $ownerId)
    {
        return $this->teamRepository->byOwner($ownerId);
    }

    public function getByUser(int $userId)
    {
        return $this->teamRepository->byUser($userId);
    }

    public function getActiveByUser(int $userId)
    {
        return $this->teamRepository->activeByUser($userId);
    }

    public function getMembers(int $teamId)
    {
        return $this->teamRepository->members($teamId);
    }

    public function getTasks(int $teamId, array $filters = [])
    {
        $query = \App\Models\Task::with('assignee')->where('team_id', $teamId);

        // 1. Filter berdasarkan Status
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // 2. Filter berdasarkan User (PIC)
        if (!empty($filters['assigned_to'])) {
            $query->where('assigned_to', $filters['assigned_to']);
        }

        // 3. Search Task berdasarkan keyword (Judul atau Kode Task)
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('title', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('code', 'like', '%' . $filters['search'] . '%');
            });
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function getDashboard(int $teamId)
    {
        return $this->teamRepository->dashboard($teamId);
    }

    public function getActivities(int $teamId)
    {
        return \App\Models\WorkspaceActivity::with('actor')
            ->where('team_id', $teamId)
            ->orderBy('created_at', 'desc')
            ->limit(30)
            ->get();
    }
}