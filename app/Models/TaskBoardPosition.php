<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskBoardPosition extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'task_id',
        'status',
        'position',
        'updated_by',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class); 
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class); 
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by'); 
    }
}