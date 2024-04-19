<?php

namespace App\Repositories\Administration;

use App\Models\Permission;
use App\Packages\Emerald\Repositories\RepositoryCrud;

class PermissionRepository extends RepositoryCrud
{
    public function __construct(Permission $model)
    {
        parent::__construct($model);
    }
}
