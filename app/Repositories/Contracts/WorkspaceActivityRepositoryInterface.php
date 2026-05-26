<?php

namespace App\Repositories\Contracts;

interface WorkspaceActivityRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function byTeam($teamId);
    public function byTask($taskId);
    public function byActor($userId);
    public function byAction($action);
    public function latest($teamId, int $limit);
    public function latestByTask($taskId, int $limit);
    public function recordTaskCreated($taskId, $actorId);
    public function recordTaskUpdated($taskId, $actorId, $before, $after);
    public function recordStatusChanged($taskId, $actorId, $from, $to);
    public function recordTaskAssigned($taskId, $actorId, $oldUserId, $newUserId);
    public function recordMemberAdded($teamId, $actorId, $userId);
    public function recordMemberRemoved($teamId, $actorId, $userId);
}