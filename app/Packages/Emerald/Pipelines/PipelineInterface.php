<?php

namespace App\Packages\Emerald\Pipelines;

use Closure;

interface PipelineInterface
{
    /**
     * @param $query
     * @param Closure $next
     * @return mixed
     */
    public function handle($query, Closure $next): mixed;

}
