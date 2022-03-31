<?php

namespace Juzaweb\Translation\Providers;

use Juzaweb\Facades\ActionRegister;
use Juzaweb\Support\ServiceProvider;
use Juzaweb\Translation\TranslationAction;

class TranslationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        ActionRegister::register(TranslationAction::class);
        
        $this->loadViewsFrom(
            __DIR__ . '/../resources/views',
            'jutr'
        );
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
