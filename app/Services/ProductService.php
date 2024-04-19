<?php

namespace App\Services;

use App\Packages\Emerald\Services\Services;
use App\Repositories\ProductRepository;
use Illuminate\Http\{JsonResponse, Request};
use Illuminate\Pipeline\Pipeline;
use Yajra\DataTables\DataTables;
use Exception;

class ProductService extends Services
{
    public function __construct(){
        $this->repository = app(ProductRepository::class);
    }

    /**
     * @param Request $request
     * @param array $filters
     * @return JsonResponse
     * @throws Exception
     */
    public function handleList(Request $request, array $filters = []): JsonResponse
    {
        $query = $this->repository->getModel()->newQuery()->with(['category']);

        return DataTables::of(app(Pipeline::class)->send($query)->through($filters)->thenReturn())
            ->editColumn('name', function ($item){ return $item->name; })
            ->editColumn('category', function ($item){ return $item->category?->name; })
            ->toJson();
    }
}
