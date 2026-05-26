<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DashboardMetric extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'user_id',
        'scope',
        'total_tasks',
        'todo_tasks',
        'in_progress_tasks',
        'done_tasks',
        'pending_tasks',
        'overdue_tasks',
        'unassigned_tasks',
        'last_calculated_at',
    ];

    protected $casts = [
        'last_calculated_at' => 'datetime',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class); 
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class); 
    }
}