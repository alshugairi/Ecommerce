<?php

namespace App\Packages\Emerald\Livewire\Components\Traits;

use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\{WithPagination};

trait IndexServiceHelper
{
    use WithPagination;

    public string $search = '';
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';
    public int $paginatePerPage = 50;
    public bool $showToast = true;

    /**
     * @param $field
     * @return void
     */
    public function sortByColumn($field): void
    {
        $this->sortDirection = ($this->sortField === $field) ? $this->reverseSort() : 'asc';
        $this->sortField = $field;
    }

    /**
     * @return string
     */
    private function reverseSort(): string
    {
        return $this->sortDirection === 'asc'
            ? 'desc'
            : 'asc';
    }

    /**
     * Resets the page number when the search text changes.
     *
     * @return void
     */
    public function updatingSearch(): void
    {
        $this->showToast = false;
        $this->resetPage();
    }

    /**
     * Resets the page number when the per-page value changes.
     *
     * @return void
     */
    public function updatingPaginate(): void
    {
        $this->showToast = false;
        $this->resetPage();
    }

    /**
     * Shows a toast message when the page number changes.
     *
     * @param int $page The new page number.
     * @return void
     */
    public function updatingPage(int $page): void
    {
        if ($this->showToast) {
            $trans = trans('share.Current Page');
            $this->emit('page', "$trans ( $page )");
            return;
        }
        $this->showToast = true;
    }


    /**
     * @return LengthAwarePaginator
     */
    private function emptyData(): LengthAwarePaginator
    {
        return $this->toPaginator(perPage: $this->paginatePerPage);
    }

    /**
     * @param array $items
     * @param int $total
     * @param int $perPage
     * @param int $currentPage
     * @return LengthAwarePaginator
     */
    private function toPaginator(array $items = [], int $total = 0, int $perPage = 10, int $currentPage = 1): LengthAwarePaginator
    {
        return new LengthAwarePaginator($items, $total, $perPage, $currentPage);
    }

}
