<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory, SoftDeletes; 

    protected $fillable = [
        'owner_id',
        'name',
        'slug',
        'description',
        'status',
        'visibility',
    ];

    
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    
    public function members(): HasMany
    {
        return $this->hasMany(TeamMember::class);
    }

    
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'team_members')
                    ->withPivot('role', 'status');
    }

    
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

        public function activities(): HasMany
    {
        return $this->hasMany(WorkspaceActivity::class);
    }
}