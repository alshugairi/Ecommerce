<?php

namespace App\Helpers;

use Exception;
use Illuminate\Support\Str;

class StringHelper
{
    /**
     * @param string $separator
     * @param string|null $string $string
     * @return string
     */
    public static function getEverythingBefore(string $separator, ?string $string): string
    {
        $array = explode($separator, $string, 2);
        if (count($array) > 0) {
            return $array[0];
        }
        return '';
    }

    /**
     * @param string $separator
     * @param string|null $string $string
     * @return string
     */
    public static function getEverythingAfter(string $separator, ?string $string): string
    {
        $array = explode($separator, $string, 2);
        if (count($array) > 0) {
            return $array[1] ?? '';
        }
        return '';
    }

    /**
     * @param int $length
     * @return string
     */
    public static function uniqueString(int $length = 16): string
    {
        return time() . '_' . Str::random($length);
    }

    /**
     * @param string $string
     * @return string
     */
    public static function asHTML(string $string): string
    {
        return <<<HTML
                $string
                HTML;
    }

    /**
     * @param int $length
     * @return string
     * @throws Exception
     */
    public static function randomString(int $length = 10): string
    {
        return substr(string: bin2hex(string: random_bytes($length)), offset: 0, length: $length);
    }
}
