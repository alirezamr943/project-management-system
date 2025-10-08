<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = [
        "title",
        "description",
        "start_date",
        "end_date",
        "status"
    ];

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'project_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            Task::class,
            'project_id',
            'assigned_to',
            'id',
            'id'
        );
    }
}
