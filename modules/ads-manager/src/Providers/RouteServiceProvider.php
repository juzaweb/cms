<?php

namespace Juzaweb\Modules\AdsManagement\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Juzaweb\Modules\Core\Facades\Locale;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->routes(function () {
            // Route::middleware('api')
            //     ->prefix('api/v1')
            //     ->group(__DIR__ . '/../routes/api.php');

            $adminPrefix = $this->app['config']->get('core.admin_prefix');

            Route::middleware(['admin'])
                ->prefix($adminPrefix)
                ->group(__DIR__ . '/../routes/admin.php');

            Route::middleware(['theme'])
                ->prefix(Locale::setLocale())
                ->group(__DIR__ . '/../routes/web.php');
        });
    }
}
