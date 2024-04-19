<?php

namespace App\Repositories;

use App\Models\Product;
use App\Packages\Emerald\Repositories\RepositoryCrud;

class ProductRepository extends RepositoryCrud
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }
}
