<?php

namespace App\Packages\Emerald\Traits;

use Illuminate\{Http\JsonResponse, Http\Request, Pipeline\Pipeline};
use Exception;
use Yajra\DataTables\DataTables;

trait ServiceFunctions
{
    /**
     * @param array $filters
     * @param int $paginate
     * @return mixed
     */
    public function handleIndex(array $filters, int $paginate = 10): mixed
    {
        $model = $this->repository->getModel()->newQuery();

        return app(Pipeline::class)
            ->send($model)
            ->through($filters)
            ->thenReturn()
            ->paginate($paginate);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function handleCreate(array $data): mixed
    {
        return $this->repository->store($data);
    }

    /**
     * @param int $id
     * @return void
     */
    public function handleDelete(int $id): void
    {
        $this->repository->destroy($id);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function handleEdit(int $id): mixed
    {
        return $this->repository->edit($id);
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function handleUpdate(array $data, int $id): mixed
    {
        return $this->repository->update($data, $id);
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
        return DataTables::of(app(Pipeline::class)->send($query)->through($filters)->thenReturn())->toJson();
    }


    /**
     * @return mixed
     */
    public function getAll(): mixed
    {
        return $this->repository->get();
    }
}
