<?php

namespace App\Repositories\Eloquent;

use App\Models\WorkspaceActivity;
use App\Models\Task;
use App\Models\User; 
use App\Support\Constants\WorkspaceActivityConstants;
use App\Repositories\Contracts\WorkspaceActivityRepositoryInterface;

class WorkspaceActivityRepository extends BaseRepository implements WorkspaceActivityRepositoryInterface
{
    public function __construct(WorkspaceActivity $model)
    {
        parent::__construct($model);
    }

    public function byTeam($teamId)
    {
        return $this->model->where('team_id', $teamId)->get();
    }

    public function byTask($taskId)
    {
        return $this->model->where('task_id', $taskId)->get();
    }

    public function byActor($userId)
    {
        return $this->model->where('actor_id', $userId)->get();
    }

    public function byAction($action)
    {
        return $this->model->where('action', $action)->get();
    }

    public function latest($teamId, int $limit)
    {
        return $this->model->where('team_id', $teamId)->latest('created_at')->limit($limit)->get();
    }

    public function latestByTask($taskId, int $limit)
    {
        return $this->model->where('task_id', $taskId)->latest('created_at')->limit($limit)->get();
    }

    public function recordTaskCreated($taskId, $actorId)
    {
        $task = Task::find($taskId);
        return $this->create([
            'team_id' => $task->team_id,
            'task_id' => $taskId,
            'actor_id' => $actorId,
            'action' => WorkspaceActivityConstants::ACTION_TASK_CREATED,
            'subject_type' => 'task',
            'subject_id' => $taskId,
            'description' => "Membuat task baru: '{$task->title}'", // Diubah
        ]);
    }

    public function recordTaskUpdated($taskId, $actorId, $before, $after)
    {
        $task = Task::find($taskId);
        return $this->create([
            'team_id' => $task->team_id,
            'task_id' => $taskId,
            'actor_id' => $actorId,
            'action' => WorkspaceActivityConstants::ACTION_TASK_UPDATED,
            'subject_type' => 'task',
            'subject_id' => $taskId,
            'description' => "Memperbarui task: '{$task->title}'", // Diubah
            'before_data' => $before,
            'after_data' => $after,
        ]);
    }

    public function recordStatusChanged($taskId, $actorId, $from, $to)
    {
        $task = Task::find($taskId);
        $statusTo = strtoupper(str_replace('_', ' ', $to)); 
        
        return $this->create([
            'team_id' => $task->team_id,
            'task_id' => $taskId,
            'actor_id' => $actorId,
            'action' => WorkspaceActivityConstants::ACTION_STATUS_CHANGED,
            'subject_type' => 'task',
            'subject_id' => $taskId,
            'description' => "Mengubah status '{$task->title}' menjadi {$statusTo}", 
            'before_data' => ['status' => $from],
            'after_data' => ['status' => $to],
        ]);
    }

    public function recordTaskAssigned($taskId, $actorId, $oldUserId, $newUserId)
    {
        $task = Task::find($taskId);
        $user = User::find($newUserId);
        $userName = $user ? $user->name : 'seseorang'; 

        return $this->create([
            'team_id' => $task->team_id,
            'task_id' => $taskId,
            'actor_id' => $actorId,
            'action' => WorkspaceActivityConstants::ACTION_TASK_ASSIGNED,
            'subject_type' => 'task',
            'subject_id' => $taskId,
            'description' => "Menugaskan '{$task->title}' kepada {$userName}", 
            'before_data' => ['assigned_to' => $oldUserId],
            'after_data' => ['assigned_to' => $newUserId],
        ]);
    }

    public function recordMemberAdded($teamId, $actorId, $userId)
    {
        $user = User::find($userId);
        $userName = $user ? $user->name : 'Anggota';

        return $this->create([
            'team_id' => $teamId,
            'actor_id' => $actorId,
            'action' => WorkspaceActivityConstants::ACTION_MEMBER_ADDED,
            'subject_type' => 'member',
            'subject_id' => $userId,
            'description' => "Menambahkan {$userName} ke dalam workspace",
        ]);
    }

    public function recordMemberRemoved($teamId, $actorId, $userId)
    {
        $user = User::find($userId);
        $userName = $user ? $user->name : 'Anggota';
        return $this->create([
            'team_id' => $teamId,
            'actor_id' => $actorId,
            'action' => WorkspaceActivityConstants::ACTION_MEMBER_REMOVED,
            'subject_type' => 'member',
            'subject_id' => $userId,
            'description' => "Mengeluarkan {$userName} dari workspace", 
        ]);
    }
}