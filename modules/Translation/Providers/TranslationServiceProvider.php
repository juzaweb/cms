<?php

namespace Juzaweb\Translation\Providers;

use Juzaweb\CMS\Facades\ActionRegister;
use Juzaweb\CMS\Support\ServiceProvider;
use Juzaweb\Translation\Contracts\TranslationContract;
use Juzaweb\Translation\Support\Locale;
use Juzaweb\Translation\TranslationAction;

class TranslationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'translation');

        ActionRegister::register(TranslationAction::class);
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);

        $this->app->singleton(
            TranslationContract::class,
            function () {
                return new Locale();
            }
        );
    }
}
