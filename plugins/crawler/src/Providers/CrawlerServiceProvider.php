<?php

namespace Juzaweb\Crawler\Providers;

use Juzaweb\Crawler\CrawlerAction;
use Juzaweb\Support\ServiceProvider;

class CrawlerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerAction(
            [
                CrawlerAction::class
            ]
        );

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'crawler');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'crawler');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
