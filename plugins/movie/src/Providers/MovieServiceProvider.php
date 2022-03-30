<?php

namespace Juzaweb\Movie\Providers;

use Juzaweb\Facades\ActionRegister;
use Juzaweb\Support\ServiceProvider;

class MovieServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        ActionRegister::register(\Juzaweb\Movie\MovieAction::class);
        
        $viewPath = __DIR__ .'/../resources/views';
        $langPath = __DIR__ . '/../resources/lang';
        
        $domain = 'mymo';
        if (is_dir($viewPath)) {
            $this->loadViewsFrom($viewPath, $domain);
        }

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $domain);
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
