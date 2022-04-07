<?php

namespace Juzaweb\Seo\Providers;

use Juzaweb\CMS\Facades\ActionRegister;
use Juzaweb\Seo\SeoAction;
use Juzaweb\CMS\Support\ServiceProvider;

class SeoServiceProvider extends ServiceProvider
{
    public function boot()
    {
        ActionRegister::register(SeoAction::class);
        
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'jseo');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'jseo');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }

    public function register()
    {
        $this->app->register(EventServiceProvider::class);
    }
}
