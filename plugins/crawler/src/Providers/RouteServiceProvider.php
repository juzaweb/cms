<?php

namespace Juzaweb\Crawler\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function map()
    {
        $this->mapAdminRoutes();
    }

    protected function mapAdminRoutes()
    {
        Route::middleware('admin')
            ->prefix(config('juzaweb.admin_prefix'))
            ->group(__DIR__ . '/../routes/admin.php');
    }
}
