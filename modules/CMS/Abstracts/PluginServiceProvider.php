<?php

namespace Juzaweb\CMS\Abstracts;

use Illuminate\Support\ServiceProvider;
use Juzaweb\CMS\Contracts\RepositoryInterface;
use Juzaweb\CMS\Providers\BootstrapServiceProvider;
use Juzaweb\CMS\Providers\ConsoleServiceProvider;
use Juzaweb\CMS\Providers\ContractsServiceProvider;

abstract class PluginServiceProvider extends ServiceProvider
{
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
        $configPath = __DIR__ . '/../../config/plugin.php';
        $this->mergeConfigFrom($configPath, 'plugin');
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
        return [RepositoryInterface::class, 'plugins'];
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
