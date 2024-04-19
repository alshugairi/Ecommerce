<?php

namespace App\Packages\Emerald\Repositories\Filters;

use App\Packages\Emerald\Pipelines\PipelineInterface;
use Spatie\DataTransferObject\DataTransferObject;

class FiltersPipeline extends DataTransferObject
{
    private array $filters;

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /**
     * @param PipelineInterface $filters
     * @return $this
     */
    public function setFilters(PipelineInterface $filters): static
    {
        $this->filters[] = $filters;

        return $this;
    }

    /**
     * @return bool
     */
    public function isFiltersEmpty(): bool
    {
        return empty($this->filters);
    }

    /**
     * @return bool
     */
    public function isFiltersNotEmpty(): bool
    {
        return !$this->isFiltersEmpty();
    }


}
