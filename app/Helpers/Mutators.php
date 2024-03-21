<?php

namespace App\Helpers;

class Mutators
{
    /**
     * Mutate telephone numbers to clean type.
     *
     * @param string|null $str
     * @return string|null
     */
    public static function cleanPhone(?string $str): ?string
    {
        if ($str) {
            return preg_replace('/[^+\d]/', '', $str);
        }

        return null;
    }
}
