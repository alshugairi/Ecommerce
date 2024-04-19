<?php

namespace App\Repositories\Administration;

use App\Models\Language;
use App\Packages\Emerald\Repositories\RepositoryCrud;

class LanguageRepository extends RepositoryCrud
{

    public function __construct(Language $model)
    {
        parent::__construct($model);
    }
}
