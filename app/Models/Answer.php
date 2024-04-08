<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends Model
{
    protected function surveyItem(): BelongsTo
    {
        return $this->belongsTo(SurveyItem::class);
    }

    protected function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
