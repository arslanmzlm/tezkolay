<?php

namespace App\Models;

use App\Enums\SurveyState;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Survey extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $casts = [
        'state' => SurveyState::class,
    ];

    /**
     * Get the workspace that owns the group.
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Get the template that owns the survey.
     */
    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }

    /**
     * Get the questions belonged to the survey.
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class)->orderBy('order');
    }

    /**
     * Get the items belonged to the survey.
     */
    public function items(): HasMany
    {
        return $this->hasMany(SurveyItem::class);
    }

    public function getGroupNameAttribute(): string
    {
        return $this->group->name;
    }

    public function getGroupSizeAttribute(): int
    {
        return $this->group->size;
    }

    public function getCompletedCountAttribute(): int
    {
        return $this->items()->whereNotNull('completed_at')->count();
    }

    public function getCompletedPercentAttribute(): float
    {
        if ($this->completed_count === 0 || $this->group_size === 0) {
            return 0;
        }

        return ($this->completed_count * 100) / $this->group_size;
    }

    public function isCanInitialize(): bool
    {
        return !$this->questions()->exists() && $this->state === SurveyState::Created;
    }
}
