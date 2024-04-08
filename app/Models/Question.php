<?php

namespace App\Models;

use App\Enums\TypeCategory;
use App\Enums\TypeComponent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'required' => 'boolean',
        'values' => 'array',
        'options' => 'array',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['category', 'component'];

    /**
     * Get the question type the question is belonged to.
     *
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    /**
     * Get the template the question is belonged to.
     *
     * @return BelongsTo
     */
    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }

    public function getComponentAttribute(): TypeComponent
    {
        return $this->type->component;
    }

    public function getCategoryAttribute(): TypeCategory
    {
        return $this->type->category;
    }

    public function hasRelation(): bool
    {
        return in_array($this->component, TypeComponent::hasRelation());
    }

    public function hasMultipleAnswer(): bool
    {
        return in_array($this->component, TypeComponent::hasMultipleAnswer());
    }

    public function isInput(): bool
    {
        return $this->category === TypeCategory::Input;
    }
}
