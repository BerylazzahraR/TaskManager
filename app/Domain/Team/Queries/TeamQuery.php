<?php

namespace App\Domain\Team\Queries;

use App\Repositories\Contracts\TeamRepositoryInterface;

class TeamQuery
{
    public function __construct(
        protected TeamRepositoryInterface $teamRepository
    ) {}

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

    public function getTasks(int $teamId)
    {
        return $this->teamRepository->tasks($teamId);
    }

    public function getDashboard(int $teamId)
    {
        return $this->teamRepository->dashboard($teamId);
    }
}