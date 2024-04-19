<?php

namespace App\Routes;

use App\Http\Controllers\ProfileController;
use App\Routes\Interfaces\RoutesInterface;
use Illuminate\Support\Facades\Route;

class ProfileRoutes implements RoutesInterface
{
    /**
     * @return void
     */
    public static function registerRoutes(): void
    {
        Route::group(attributes: ['prefix' => 'profile', 'as' => 'profile.'], routes: static function () {
            Route::get(uri: '/', action: [ProfileController::class, 'overview'])->name(name: 'overview');
            Route::post(uri: '/', action: [ProfileController::class, 'update'])->name(name: 'update');
            Route::post(uri: '/change-password', action: [ProfileController::class, 'changePassword'])->name(name: 'change_password');
        });
    }
}
