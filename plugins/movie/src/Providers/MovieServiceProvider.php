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
