<?php

namespace Juzaweb\CMS\Providers;

use Illuminate\Support\ServiceProvider;
use Juzaweb\CMS\Contracts\PluginRepositoryInterface;
use Juzaweb\CMS\Facades\ActionRegister;

class BootstrapServiceProvider extends ServiceProvider
{
    /**
     * Booting the package.
     */
    public function boot(): void
    {
        $this->app[PluginRepositoryInterface::class]->boot();

        $this->booted(
            function () {
                ActionRegister::init();

                do_action('juzaweb.init');
            }
        );
    }

    /**
     * Register the provider.
     */
    public function register(): void
    {
        $this->app[PluginRepositoryInterface::class]->register();
    }
}
