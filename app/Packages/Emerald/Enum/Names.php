<?php

namespace App\Packages\Emerald\Enum;

trait Names
{
    /**
     * Get an array of case names
     * @return array
     */
    public static function names(): array
    {
        return array_column(static::cases(), 'name');
    }
}
