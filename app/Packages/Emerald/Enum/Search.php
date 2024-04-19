<?php

namespace App\Packages\Emerald\Enum;

trait Search
{
    /**
     * @param string $enum
     * @return mixed
     */
    public static function get(string $enum)
    {
        if (!static::isExists($enum)) {
            return null;
        }
        return constant("self::$enum");
    }

    /**
     * @param string $enum
     * @param string $column
     * @return bool
     */
    public static function isExists(string $enum, string $column = 'name'): bool
    {
        return in_array($enum, array_column(static::cases(), $column), true);
    }
}
