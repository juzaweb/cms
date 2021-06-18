<?php

namespace Mymo\Plugin;

use Illuminate\Support\ServiceProvider;
use Mymo\Plugin\Providers\BootstrapServiceProvider;
use Mymo\Plugin\Providers\ConsoleServiceProvider;
use Mymo\Plugin\Providers\ContractsServiceProvider;

abstract class ModulesServiceProvider extends ServiceProvider
{
    /**
     * Booting the package.
     */
    public function boot()
    {
    }

    /**
     * Register all plugins.
     */
    public function register()
    {
    }

    /**
     * Register all plugins.
     */
    protected function registerModules()
    {
        $this->app->register(BootstrapServiceProvider::class);
    }

    /**
     * Register package's namespaces.
     */
    protected function registerNamespaces()
    {
        $configPath = __DIR__ . '/config/config.php';

        $this->mergeConfigFrom($configPath, 'modules');
        /*$this->publishes([
            $configPath => config_path('modules.php'),
        ], 'config');*/
    }

    /**
     * Register the service provider.
     */
    abstract protected function registerServices();

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Contracts\RepositoryInterface::class, 'modules'];
    }

    /**
     * Register providers.
     */
    protected function registerProviders()
    {
        $this->app->register(ConsoleServiceProvider::class);
        $this->app->register(ContractsServiceProvider::class);
    }
}
