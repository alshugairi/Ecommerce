<?php

namespace App\Pipelines;

use App\Packages\Emerald\Pipelines\PipelineInterface;
use Closure;

class SortFilterPipeline implements PipelineInterface
{
    /**
     * @param string $sortByColumn
     * @param string $sortType
     */
    public function __construct(
        private string $sortByColumn,
        private string $sortType = 'desc',
    )
    {
    }

    /**
     * @param $query
     * @param Closure $next
     * @return mixed
     */
    public function handle($query, Closure $next): mixed
    {
        if (!empty($this->sortByColumn)) {
            $query->orderBy($this->sortByColumn, $this->sortType);
        }

        return $next($query);
    }
}
