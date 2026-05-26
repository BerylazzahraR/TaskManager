<?php

namespace App\Repositories\Eloquent;

use App\Models\Task;
use App\Support\Constants\TaskConstants;
use App\Repositories\Contracts\TaskRepositoryInterface;
use Carbon\Carbon;

class TaskRepository extends BaseRepository implements TaskRepositoryInterface
{
    public function __construct(Task $model)
    {
        parent::__construct($model);
    }

    public function findByCode($code)
    {
        return $this->model->where('code', $code)->firstOrFail();
    }

    public function restore($id)
    {
        $task = $this->model->withTrashed()->findOrFail($id);
        $task->restore();
        return $task;
    }

    public function byTeam($teamId)
    {
        return $this->model->where('team_id', $teamId)->get();
    }

    public function byStatus($teamId, $status)
    {
        return $this->model->where('team_id', $teamId)->where('status', $status)->get();
    }

    public function byAssignee($teamId, $userId)
    {
        return $this->model->where('team_id', $teamId)->where('assigned_to', $userId)->get();
    }

    public function byCreator($teamId, $userId)
    {
        return $this->model->where('team_id', $teamId)->where('created_by', $userId)->get();
    }

    public function byPriority($teamId, $priority)
    {
        return $this->model->where('team_id', $teamId)->where('priority', $priority)->get();
    }

    public function unassigned($teamId)
    {
        return $this->model->where('team_id', $teamId)->whereNull('assigned_to')->get();
    }

    public function pending($teamId)
    {
        return $this->model->where('team_id', $teamId)
            ->where('status', '!=', TaskConstants::STATUS_DONE)
            ->get();
    }

    public function completed($teamId)
    {
        return $this->model->where('team_id', $teamId)
            ->where('status', TaskConstants::STATUS_DONE)
            ->get();
    }

    public function overdue($teamId)
    {
        return $this->model->where('team_id', $teamId)
            ->where('status', '!=', TaskConstants::STATUS_DONE)
            ->where('deadline_at', '<', now())
            ->get();
    }

    public function dueSoon($teamId, int $days)
    {
        return $this->model->where('team_id', $teamId)
            ->where('status', '!=', TaskConstants::STATUS_DONE)
            ->whereBetween('deadline_at', [now(), now()->addDays($days)])
            ->get();
    }

    public function search($teamId, $keyword)
    {
        return $this->model->where('team_id', $teamId)
            ->where(function ($query) use ($keyword) {
                $query->where('title', 'like', "%{$keyword}%")
                    ->orWhere('code', 'like', "%{$keyword}%");
            })->get();
    }

    public function filter($teamId, array $params)
    {
        $query = $this->model->where('team_id', $teamId);

        if (isset($params['status']))
            $query->where('status', $params['status']);
        if (isset($params['priority']))
            $query->where('priority', $params['priority']);
        if (isset($params['assigned_to']))
            $query->where('assigned_to', $params['assigned_to']);

        return $query->get();
    }

    public function assignTo($taskId, $userId)
    {
        return $this->update($taskId, ['assigned_to' => $userId]);
    }

    public function changeStatus($taskId, $status, $userId)
    {
        $data = ['status' => $status];
        if ($status === TaskConstants::STATUS_DONE) {
            $data['completed_at'] = now();
        } else {
            $data['completed_at'] = null;
        }
        return $this->update($taskId, $data);
    }

    public function changeDeadline($taskId, $deadline)
    {
        return $this->update($taskId, ['deadline_at' => Carbon::parse($deadline)]);
    }

    public function dashboardSummary($teamId)
    {
        return $this->model->where('team_id', $teamId)
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->get();
    }

    public function reorder($taskId, $status, $position)
    {
        return $this->update($taskId, [
            'status' => $status,
            'position' => $position
        ]);
    }
}