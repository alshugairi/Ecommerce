<?php

namespace App\Repositories\Administration;

use App\Models\Role;
use App\Packages\Emerald\Repositories\RepositoryCrud;

class RoleRepository extends RepositoryCrud
{

    public function __construct(Role $model)
    {
        parent::__construct($model);
    }
}
