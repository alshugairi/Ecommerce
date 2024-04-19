<?php

namespace App\Packages\Emerald\Observers;


trait ObserverHelper
{
    /**
     * @param string $guard
     * @return int|null
     */
    public function getUserId(string $guard = 'sanctum'): ?int
    {
        return auth($guard)->id();
    }
}
