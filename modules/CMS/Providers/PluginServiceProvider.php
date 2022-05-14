<?php

namespace Juzaweb\CMS\Providers;

use Juzaweb\CMS\Contracts\ActivatorInterface;
use Juzaweb\CMS\Contracts\PluginRepositoryInterface;
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
        return [PluginRepositoryInterface::class, 'plugins'];
    }

    protected function registerServices()
    {
        $this->app->singleton(
            PluginRepositoryInterface::class,
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

                return new $class($app);
            }
        );

        $this->app->alias(PluginRepositoryInterface::class, 'plugins');
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
