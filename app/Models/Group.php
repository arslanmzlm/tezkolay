<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the workspace that owns the group.
     */
    public function workspace(): BelongsTo
    {
        return $this->belongsTo(Workspace::class);
    }

    /**
     * Get all the patients for the group.
     */
    public function patients(): HasMany
    {
        return $this->hasMany(Patient::class);
    }

    /**
     * Get all the surveys for the group.
     */
    public function surveys(): HasMany
    {
        return $this->hasMany(Survey::class);
    }

    public function getWorkspaceNameAttribute(): string
    {
        return $this->workspace->name;
    }

    public function getUserIdAttribute(): int
    {
        return $this->workspace->user_id;
    }
}
