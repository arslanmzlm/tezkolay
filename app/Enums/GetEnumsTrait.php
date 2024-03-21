<?php

namespace App\Enums;

use Illuminate\Support\Arr;

trait GetEnumsTrait
{
    public static function all(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function fromNames(mixed $statuses): array
    {
        return collect(Arr::wrap($statuses))
            ->transform(fn($status, $name) => constant("self::$name")->value)
            ->toArray();
    }
}
