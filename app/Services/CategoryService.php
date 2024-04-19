<?php

namespace App\Services;

use App\Packages\Emerald\Services\Services;
use App\Repositories\CategoryRepository;
use Exception;
use Illuminate\{Http\JsonResponse, Http\Request, Pipeline\Pipeline};
use Yajra\DataTables\DataTables;

class CategoryService extends Services
{
    public function __construct(){
        $this->repository = app(CategoryRepository::class);
    }

    /**
     * @param Request $request
     * @param array $filters
     * @return JsonResponse
     * @throws Exception
     */
    public function handleList(Request $request, array $filters = []): JsonResponse
    {
        $query = $this->repository->getModel()->newQuery();

        return DataTables::of(app(Pipeline::class)->send($query)->through($filters)->thenReturn())
            ->editColumn('name', function ($item){ return $item->name; })
            ->toJson();
    }
}
