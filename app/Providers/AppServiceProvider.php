<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\{ServiceProvider, Facades\Cache};
use App\{Helpers\TemplateHelper\DesignHelper, Services\Administration\LanguageService};

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('*', function ($view) {
            $view->with('language', DesignHelper::getLanguage());
            $view->with('direction', DesignHelper::getDirection());
            $view->with('designHelper', DesignHelper::class);
            $view->with('carbon', Carbon::class);
            //$view->with('role', Auth::user()?->getRoleNames()->first());

            $appLanguages = Cache::remember('appLanguages', 3600, function () {
                return app(LanguageService::class)->getAll();
            });
            $view->with('appLanguages', $appLanguages);
        });
    }
}
