<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes; 

    protected $fillable = [
        'team_id',
        'code',           
        'title',
        'slug',
        'description',
        'created_by',
        'assigned_to',
        'status',         
        'priority',       
        'deadline_at',
        'completed_at',
        'position',       
    ];

    protected $casts = [
        'deadline_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class); 
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by'); 
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to'); 
    }

    public function comments(): HasMany
    {
        return $this->hasMany(TaskComment::class)->orderBy('created_at', 'asc'); 
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(TaskAttachment::class); 
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(TaskStatusHistory::class); 
    }
}