<?php

namespace App\Services\Administration;

use App\Models\Role;
use App\Packages\Emerald\Services\Services;
use App\Repositories\Administration\RoleRepository;
use Illuminate\Support\Arr;

class RoleService extends Services
{
    public function __construct()
    {
        $this->repository = app(RoleRepository::class);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function handleCreate(array $data): mixed
    {
        $role = $this->repository->store(data: $this->excludePermissions(data: $this->setDefaultGuard( data: $data)));
        $role->givePermissionTo($data['role_permissions']);
        return $role;
    }

    /**
     * @param array $data
     * @return array
     */
    private function excludePermissions(array $data): array
    {
        return Arr::except(array: $data, keys: "rolePermissions");
    }

    /**
     * @param array $data
     * @return array
     */
    private function setDefaultGuard(array $data): array
    {
        $data['guard_name'] = 'web';
        return $data;
    }

    /**
     * @param int $id
     * @return array
     */
    public function getRolePermissions(int $id): array
    {
        $permissions=[];
        $role=$this->handleEdit(id: $id);
        foreach ($role->permissions as $permission){
            $permissions[]=$permission->name;
        }
        return $permissions;
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function handleUpdate(array $data, int $id): mixed
    {
        $role=$this->repository->update(data: $this->excludePermissions(data: $data), id: $id);
        $role->givePermissionTo($data['role_permissions']);
        return $role;
    }

    /**
     * @param Role $role
     * @return array
     */
    public function getRolePermissionIds(Role $role): array
    {
        return $role->permissions()->pluck('name')->toArray();
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $roles = $this->repository->get();

        $rolesArr = [];
        foreach ($roles as $role) {
            $rolesArr[$role->name] = $role->name;
        }
        return $rolesArr;
    }
}
