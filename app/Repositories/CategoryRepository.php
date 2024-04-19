<?php

namespace App\Repositories;

use App\Models\Category;
use App\Packages\Emerald\Repositories\RepositoryCrud;

class CategoryRepository extends RepositoryCrud
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }
}
