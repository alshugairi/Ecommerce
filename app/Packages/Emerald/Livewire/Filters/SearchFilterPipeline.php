<?php

namespace App\Packages\Emerald\Livewire\Filters;

use App\Packages\Emerald\Pipelines\PipelineInterface;
use Closure;

class SearchFilterPipeline implements PipelineInterface
{
    /**
     * @param array $columns
     * @param ?string $search
     */
    public function __construct(
        private readonly array  $columns,
        private readonly ?string $search
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
        if (!empty($this->search) && count(value: $this->columns)) {
            $query->where(function ($query) {
                foreach ($this->columns as $index => $column) {
                    if ($index === 0) {
                        $query->where($column, 'like', '%' . trim(string: $this->search) . '%');
                    } else {
                        $query->orWhere($column, 'like', '%' . trim(string: $this->search) . '%');
                    }
                }
            });
        }

        return $next($query);
    }
}
