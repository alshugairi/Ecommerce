<?php

namespace App\Routes;

use App\{Http\Controllers\Administration\CityController,
    Http\Controllers\Administration\CountryController,
    Http\Controllers\Administration\PermissionController,
    Http\Controllers\Administration\RoleController,
    Http\Controllers\Administration\CurrencyController,
    Http\Controllers\Administration\LanguageController,
    Routes\Interfaces\RoutesInterface};
use Illuminate\Support\Facades\Route;

class AdministrationRoutes implements RoutesInterface
{
    /**
     * @return void
     */
    public static function registerRoutes(): void
    {
        self::rolesRoutes();
        self::permissionsRoutes();
        self::languagesRoutes();
    }

    /**
     * @return void
     */
    private static function rolesRoutes(): void
    {
        Route::get(uri: '/roles/list', action: [RoleController::class, 'list'])->name(name: 'roles.list');
        Route::resource(name: 'roles', controller: RoleController::class);
    }

    /**
     * @return void
     */
    private static function permissionsRoutes(): void
    {
        Route::get(uri: '/permissions/list', action: [PermissionController::class, 'list'])->name(name: 'permissions.list');
        Route::resource(name: 'permissions', controller: PermissionController::class);
    }

    /**
     * @return void
     */
    private static function languagesRoutes(): void
    {
        Route::get(uri: '/languages/list', action: [LanguageController::class, 'list'])->name(name: 'languages.list');
        Route::resource(name: 'languages', controller: LanguageController::class);
    }
}
