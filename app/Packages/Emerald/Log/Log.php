<?php

namespace App\Packages\Emerald\Log;

use Carbon\Carbon;

class Log
{
    /**
     * @param $exception
     */
    public static function Logging($exception): void
    {
        static::startTime();
        \Illuminate\Support\Facades\Log::channel('payment')->info($exception);
    }

    /**
     *
     */
    private static function startTime(): void
    {
        \Illuminate\Support\Facades\Log::channel('payment')->info(Carbon::now());
    }
}
