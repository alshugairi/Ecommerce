<?php

namespace App\Routes;

use App\{Http\Controllers\Account\CaptainController,
    Http\Controllers\Account\FleetManagerController,
    Http\Controllers\Account\UserController,
    Http\Controllers\Account\ClientController,
    Routes\Interfaces\RoutesInterface};
use Illuminate\Support\Facades\Route;

class AccountRoutes implements RoutesInterface
{
    /**
     * @return void
     */
    public static function registerRoutes(): void
    {
        Route::get(uri: '/users/list', action: [UserController::class, 'list'])->name(name: 'users.list');
        Route::resource(name: 'users', controller: UserController::class);
    }
}
