<?php

namespace App\Notifications;

use App\Models\Task;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TaskAssignedNotification extends Notification
{
    use Queueable;

    public $task;
    public $assigner;

    /**
     * Create a new notification instance.
     */
    public function __construct(Task $task, User $assigner)
    {
        $this->task = $task;
        $this->assigner = $assigner;
    }

    /**
     * Get the notification's delivery channels.
     * Karena kita cuma mau tampilin di icon lonceng web, kita pakai 'database'.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     * Data ini yang bakal disimpen ke database dan ditampilin di dropdown lonceng nanti.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'task_id' => $this->task->id,
            'task_title' => $this->task->title,
            'team_id' => $this->task->team_id,
            'team_slug' => $this->task->team->slug, // Biar nanti notifnya bisa diklik
            'assigner_name' => $this->assigner->name,
            'message' => 'menugaskan task baru kepadamu: ' . $this->task->title,
            'type' => 'assign_task' // Buat bedain icon notif nantinya
        ];
    }
}