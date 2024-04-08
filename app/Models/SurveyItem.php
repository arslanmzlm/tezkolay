<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SurveyItem extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $casts = [
        'sent_at' => 'timestamp',
        'completed_at' => 'timestamp',
        'filled_by_user' => 'bool'
    ];

    public function survey(): BelongsTo
    {
        return $this->belongsTo(Survey::class);
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }
}
