<?php

namespace App\Repositories\Contracts;

interface TaskRepositoryInterface
{
    public function all();
    public function find($id);
    public function findByCode($code);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function restore($id);
    public function byTeam($teamId);
    public function byStatus($teamId, $status);
    public function byAssignee($teamId, $userId);
    public function byCreator($teamId, $userId);
    public function byPriority($teamId, $priority);
    public function unassigned($teamId);
    public function pending($teamId);
    public function completed($teamId);
    public function overdue($teamId);
    public function dueSoon($teamId, int $days);
    public function search($teamId, $keyword);
    public function filter($teamId, array $params);
    public function assignTo($taskId, $userId);
    public function changeStatus($taskId, $status, $userId);
    public function changeDeadline($taskId, $deadline);
    public function dashboardSummary($teamId);
    public function reorder($taskId, $status, $position);
}