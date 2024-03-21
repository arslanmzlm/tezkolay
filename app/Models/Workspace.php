<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Workspace extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get all the groups for the workspace.
     */
    public function groups(): HasMany
    {
        return $this->hasMany(Group::class)->withCount(['patients', 'surveys']);
    }
}
