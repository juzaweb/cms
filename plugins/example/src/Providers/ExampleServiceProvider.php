<?php

namespace Juzaweb\Example\Providers;

use Juzaweb\CMS\Facades\ActionRegister;
use Juzaweb\CMS\Support\ServiceProvider;
use Juzaweb\Example\Actions\ExampleAction;

class ExampleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Register Plugin Action
        ActionRegister::register([ExampleAction::class]);
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

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
