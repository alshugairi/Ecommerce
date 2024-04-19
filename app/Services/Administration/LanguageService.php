<?php

namespace App\Services\Administration;

use App\Packages\Emerald\Services\Services;
use App\Repositories\Administration\LanguageRepository;

class LanguageService extends Services
{
    public function __construct()
    {
        $this->repository = app(LanguageRepository::class);
    }
}
