<?php

namespace App\Services\Account;

use App\{Enums\UserType, Packages\Emerald\Services\Services, Repositories\UserRepository};
use Exception;
use Illuminate\{Database\Eloquent\Model,
    Http\JsonResponse,
    Http\Request,
    Pipeline\Pipeline,
    Support\Arr,
    Support\Facades\Hash,
    Support\Facades\Storage};
use Yajra\DataTables\DataTables;

class UserService extends Services
{
    public function __construct()
    {
        $this->repository = app(UserRepository::class);
    }

    /**
     * @param array $filters
     * @param int $paginate
     * @return mixed
     */
    public function handleIndex(array $filters, int $paginate = 10): mixed
    {
        $model = $this->repository->getModel()->newQuery()->where(column: 'type', operator: '=', value: UserType::Admin->value);

        return app(abstract: Pipeline::class)
            ->send(passable: $model)
            ->through(pipes: $filters)
            ->thenReturn()
            ->paginate(
                $paginate,
                [
                    'id',
                    'name',
                    'email',
                    'phone',
                    'created_at',
                ]);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function handleCreate(array $data): mixed
    {
        $data['type'] = UserType::Admin->value;
        return $this->repository->store(data: $this->excludeRole(data: $data))->assignRole($data['role']);
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function handleUpdate(array $data, int $id): mixed
    {
        $user = $this->repository->update(data: $this->excludeRole(data: $this->checkPassword(data: $data)), id: $id);
        if (isset($data['role'])) {
            $user->assignRole($data['role']);
        }
        return $user;
    }

    /**
     * @param array $data
     * @return array
     */
    public function storePhoto(array $data): array
    {
        if (!empty($data['avatar'])) {
            $filePath = $data['avatar']->store('user', 'public');
            $data['avatar'] = asset(Storage::url($filePath));
        } else {
            $data = Arr::except($data, ['avatar']);
        }
        return $data;
    }

    /**
     * @param array $data
     * @return array
     */
    public function storePassword(array $data): array
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            $data = Arr::except($data, ['password']);
        }
        return $data;
    }

    /**
     * @param array $data
     * @return array
     */
    private function checkPassword(array $data): array
    {
        if (empty($data['password'])) {
            $data = $this->excludeRole(data: $data, key: 'password');
        }
        return $data;
    }

    /**
     * @param array $data
     * @param array|string $key
     * @return array
     */
    private function excludeRole(array $data, array|string $key = 'role'): array
    {
        return Arr::except(array: $data, keys: $key);
    }

    /**
     * @param Request $request
     * @param array $filters
     * @return JsonResponse
     * @throws Exception
     */
    public function handleList(Request $request, array $filters = []): JsonResponse
    {
        $data = $this->repository->getModel()->newQuery()->where(column: 'type', operator: '=', value: UserType::Admin->value);
        return DataTables::of($data)
                        ->addColumn('role', function ($user) {
                            return $user->roles ? $user->roles->value('name') : '';
                        })
                        ->toJson();
    }
}
