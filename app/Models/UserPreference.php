<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'default_team_id',
        'theme',             
        'task_view',        
        'email_notification',
        'in_app_notification',
        'timezone',
    ];

    protected $casts = [
        'email_notification' => 'boolean',
        'in_app_notification' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class); 
    }

    public function defaultTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'default_team_id'); 
    }
}