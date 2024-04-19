<?php /** @noinspection PhpFunctionNamingConventionInspection */

use App\{Helpers\StringHelper,};


if (!function_exists(function: 'convertArrayToObject')) {
    /**
     * @param array $array
     * @return object
     */
    function convertArrayToObject(array $array): object
    {
        try {
            return json_decode(json: json_encode(value: $array, flags: JSON_THROW_ON_ERROR), associative: false, depth: 512, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {

        }
    }
}

if (!function_exists(function: 'convertPayfortPriceToHuman')) {
    /**
     * @param string|float|int $amount
     * @return float|int
     */
    function convertPayfortPriceToHuman(string|float|int $amount): float|int
    {
        return (float)$amount / 100;
    }
}

if (!function_exists(function: 'convertPayfortPriceToHuman')) {
    /**
     * @param string|float|int $amount
     * @return float|int
     */
    function convertPricePayfort(string|float|int $amount): float|int
    {

        return (int)ceil(num: $amount) * (10 ** 2);
    }
}

if (!function_exists(function: 'renderTableImage')) {
    /**
     * @param string $path
     * @return string
     */
    function renderTableImage(string $path): string
    {
        return !empty($path) ? '<img src="'.$path.'" class="img-thumbnail rounded-2" style="max-height: 60px; width:60px">' : '';
    }
}


