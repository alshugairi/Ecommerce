<?php

namespace App\Packages\Emerald\Traits;

use Illuminate\{Auth\Access\AuthorizationException, Support\Arr};

trait RoleServiceHelper
{

    /**
     * @param string $permission
     * @return bool
     */
    public function havePermission(string $permission): bool
    {
        return auth()->user()?->can(abilities: $permission);
    }

    /**
     * @param $row
     * @return mixed
     */
    public function getRoleName($row): mixed
    {
        return $row->roles->pluck("name")->first();
    }

    /**
     * @param string $permission
     * @return void
     * @throws AuthorizationException
     */
    public function authorizePermission(string $permission): void
    {
        if (!auth()->user()?->can(abilities: $permission)) {
            throw new AuthorizationException(message: 'You do not have permission to perform this action.', code: 403);
        }
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
}
