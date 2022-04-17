<?php

namespace Juzaweb\Backend\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'Juzaweb\Backend\Http\Controllers';

    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
        $this->mapAssetRoutes();
        $this->mapAdminRoutes();
        $this->mapThemeRoutes();
    }

    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../routes/web.php');
    }

    protected function mapAdminRoutes()
    {
        Route::middleware('admin')
            ->namespace($this->namespace)
            ->prefix(config('juzaweb.admin_prefix'))
            ->group(__DIR__ . '/../routes/admin.php');
    }
    
    protected function mapThemeRoutes()
    {
        Route::middleware('theme')
            ->group(__DIR__ . '/../routes/theme.php');
    }

    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->group(__DIR__ . '/../routes/api.php');
    }

    protected function mapAssetRoutes()
    {
        Route::middleware('assets')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../routes/assets.php');
    }
    
    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for(
            'api',
            function (Request $request) {
                return Limit::perMinute(60)
                    ->by($request->user()?->id ?: $request->ip());
            }
        );
    }
}
