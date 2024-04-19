<?php

namespace App\Services\Administration;

use App\Packages\Emerald\Services\Services;
use App\Repositories\Administration\PermissionRepository;
use Illuminate\Support\Collection;

class PermissionService extends Services
{
    public function __construct()
    {
        $this->repository = app(PermissionRepository::class);
    }

    /**
     * @return array
     */
    public function getPermissionsNames(): array
    {
        $permissions = [];
        foreach ($this->allPermissions() as $permission) {
            $permissions[] = $permission->name;
        }
        return $permissions;
    }

    /**
     * @return Collection
     */
    public function allPermissions(): Collection
    {
        return $this->repository->all();
    }

    /**
     * @return array
     */
    public function groupedPermissions(): array
    {
        $groupedPermissions = [
            'permission' => [],
            'role' => [],
            'user' => [],
            'language' => [],
            'category' => [],
            'product' => [],
        ];

        foreach ($this->allPermissions() as $permission) {
            [$category, $action] = explode('.', $permission->name);
            $permission['action'] = $action;
            $groupedPermissions[$category][] = $permission;
        }
        return $groupedPermissions;
    }
}
