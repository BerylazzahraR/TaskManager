<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'user_id',
        'role',          
        'status',        
        'invited_by',
        'joined_at',
        'removed_at',
    ];

    protected $casts = [
        'joined_at' => 'datetime',
        'removed_at' => 'datetime',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class); 
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class); 
    }

    public function inviter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'invited_by'); 
    }
}