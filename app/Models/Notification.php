<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'team_id',
        'task_id',
        'triggered_by',
        'type',
        'channel',
        'title',
        'message',
        'status',
        'read_at',
        'sent_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'sent_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class); 
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class); 
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class); 
    }

    public function triggerer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'triggered_by'); 
    }
}