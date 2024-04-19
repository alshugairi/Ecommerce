<?php

namespace App\Repositories;

use App\{Models\User, Packages\Emerald\Repositories\RepositoryCrud};

class UserRepository extends RepositoryCrud
{
    /**
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * @param string $role
     * @return mixed
     */
    public function getUsersByRole(string $role): mixed
    {
        return $this
            ->getModel()
            ->whereHas('roles', function ($query) use ($role) {
                $query->where('name', $role);
            })
            ->get();
    }
}
