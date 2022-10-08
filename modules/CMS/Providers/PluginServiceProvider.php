<?php

namespace Juzaweb\CMS\Providers;

use Juzaweb\CMS\Contracts\ActivatorInterface;
use Juzaweb\CMS\Contracts\ConfigContract;
use Juzaweb\CMS\Contracts\LocalPluginRepositoryContract;
use Juzaweb\CMS\Exceptions\InvalidActivatorClass;
use Juzaweb\CMS\Support\LocalPluginRepository;
use Juzaweb\CMS\Support\ServiceProvider;

class PluginServiceProvider extends ServiceProvider
{
    /**
     * Booting the package.
     */
    public function boot()
    {
        $this->registerModules();
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerNamespaces();
        $this->registerServices();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return [LocalPluginRepositoryContract::class, 'plugins'];
    }

    protected function registerServices()
    {
        $this->app->singleton(
            LocalPluginRepositoryContract::class,
            function ($app) {
                $path = config('juzaweb.plugin.path');
                return new LocalPluginRepository($app, $path);
            }
        );

        $this->app->singleton(
            ActivatorInterface::class,
            function ($app) {
                $class = config('plugin.activator');
                if ($class === null) {
                    throw InvalidActivatorClass::missingConfig();
                }

                return new $class($app, $app[ConfigContract::class]);
            }
        );

        $this->app->alias(LocalPluginRepositoryContract::class, 'plugins');
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
        $configPath = __DIR__ . '/../config/plugin.php';
        $this->mergeConfigFrom($configPath, 'plugin');
    }
}
