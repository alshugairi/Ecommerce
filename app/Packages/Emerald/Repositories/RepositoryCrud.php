<?php

namespace App\Packages\Emerald\Repositories;

use App\Packages\Emerald\Repositories\Interfaces\RepositoryContractCrud;
use Exception;
use Illuminate\{Database\Eloquent\Model};
use RuntimeException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class RepositoryCrud extends Repository implements RepositoryContractCrud
{

    /**
     * @param array $columns
     * @param bool $isPagination
     * @param int $perPage
     * @return mixed
     */
    public function index(array $columns = ['*'], bool $isPagination = false, int $perPage = 6): mixed
    {
        $this->newQuery()->eagerLoad()->setClauses();

        $model = $this->query;

        if ($isPagination) {
            return $model->paginate($perPage, $columns);
        }

        return $model->get($columns);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function store(array $data, bool $isInsert = false): mixed
    {
        return !$isInsert ? $this->model::create($data) : $this->model::insert($data);
    }

    /**
     * @param array $data
     * @return array
     */
    public function create(array $data = []): mixed
    {
        return [];
    }

    /**
     * @param int $id
     * @return Model
     */
    public function show(int $id): mixed
    {
        return $this->find($id);
    }

    /**
     * @param int $id
     * @return Model
     */
    public function edit(int $id): mixed
    {
        $model = $this->find($id);
        if ($model) {
            return $model;
        }
        throw new NotFoundHttpException('Not found resource');
    }

    /**
     * @param int $id
     * @throws Exception
     */
    public function destroy(int $id): void
    {
        $model = $this->find($id);
        if ($model) {
            $model->delete();
            return;
        }
        throw new RuntimeException('Not found resource');
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function status(int $id): mixed
    {
        $model = $this->find($id);
        return $this->update([
            'status' => (bool)$model->status
        ], $model);
    }

    /**
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $id): mixed
    {
        if ($id instanceof Model) {
            $model = $id;
        } else {
            $model = $this->find($id);
        }

        $model->update($data);
        return $model;
    }


    /**
     * @param $id
     * @return bool
     */
    public function forceDelete($id): bool
    {
        $model = $this->find($id);
        if ($model) {
            $model->forceDelete();
            return true;
        }
        return false;
    }

    /**
     * @param $id
     * @return bool
     */
    public function restore($id): bool
    {
        $model = $this->find($id);
        if ($model) {
            $model->restore();
            return true;
        }
        return false;
    }
}
