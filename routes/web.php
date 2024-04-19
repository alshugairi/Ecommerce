<?php
use App\{Http\Controllers\HomeController,
    Http\Controllers\CategoryController,
    Http\Controllers\ProductController,
    Http\Controllers\Administration\SystemController,
    Routes\AccountRoutes,
    Routes\ProfileRoutes,
    Routes\AdministrationRoutes};
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(options: [
    'login' => true,
    'logout' => true,
    'reset' => false,
    'confirm' => false,
    'register' => false,
    'verify' => false,
]);

Route::get(uri: '/', action: static fn() => redirect(to: 'login'));
Route::group(attributes: [
    'middleware' => [
        'auth',
        //'hasPermission'
    ]
], routes: static function () {
    Route::get(uri: '/home', action: [HomeController::class, 'index'])->name(name: 'home');
    ProfileRoutes::registerRoutes();
    AccountRoutes::registerRoutes();
    AdministrationRoutes::registerRoutes();

    Route::get(uri: '/categories/list', action: [CategoryController::class, 'list'])->name(name: 'categories.list');
    Route::resource(name: 'categories', controller: CategoryController::class);

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