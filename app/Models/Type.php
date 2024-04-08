<?php

namespace App\Models;

use App\Enums\TypeCategory;
use App\Enums\TypeComponent;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
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
        'component' => TypeComponent::class,
        'category' => TypeCategory::class,
    ];
}
