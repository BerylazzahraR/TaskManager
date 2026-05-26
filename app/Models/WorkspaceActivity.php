<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkspaceActivity extends Model
{
    use HasFactory;

    
    const UPDATED_AT = null;

    protected $fillable = [
        'team_id',
        'task_id',
        'actor_id',
        'action',
        'subject_type',
        'subject_id',
        'description',
        'before_data',
        'after_data',
    ];

    protected $casts = [
        'before_data' => 'array', 
        'after_data' => 'array', 
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class); 
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class); 
    }

    public function actor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actor_id'); 
    }
}