<?php
use App\{Http\Controllers\HomeController,
    Http\Controllers\DashboardController,
    Http\Controllers\CategoryController,
    Http\Controllers\ProductController,
    Http\Controllers\Administration\SystemController,
    Routes\AccountRoutes,
    Routes\ProfileRoutes,
    Routes\AdministrationRoutes};
use Illuminate\Support\Facades\Route;
use \Illuminate\Support\Facades\Auth;


Auth::routes(options: [
    'login' => true,
    'logout' => true,
    'reset' => false,
    'confirm' => false,
    'register' => false,
    'verify' => false,
]);
Route::get(uri: '/', action: [HomeController::class, 'index'])->name(name: 'home');

Route::group(attributes: [
    'middleware' => [
        'auth',
        //'hasPermission'
    ]
], routes: static function () {
    ProfileRoutes::registerRoutes();
    AccountRoutes::registerRoutes();
    AdministrationRoutes::registerRoutes();

    Route::get(uri: '/dashboard', action: [DashboardController::class, 'index'])->name(name: 'dashboard');

    Route::get(uri: '/categories/list', action: [CategoryController::class, 'list'])->name(name: 'categories.list');
    Route::resource(name: 'categories', controller: CategoryController::class);

    Route::post(uri: '/products/bulk-actions', action: [ProductController::class, 'bulkActions'])->name(name: 'products.bulk_actions');
    Route::get(uri: '/products/print', action: [ProductController::class, 'print'])->name(name: 'products.print');
    Route::get(uri: '/products/list', action: [ProductController::class, 'list'])->name(name: 'products.list');
    Route::resource(name: 'products', controller: ProductController::class);

    Route::get(uri: '/clear-cache', action: [SystemController::class, 'clearCache'])->name(name: 'cache.clear');
});

Route::get('switch-language/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'ar'])) { abort(404); }

    app()->setLocale($locale);
    session()->put('locale', $locale);
    return back();
})->name('language.switch');
