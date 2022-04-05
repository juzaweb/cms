<?php

namespace Juzaweb\Providers;

use Juzaweb\Abstracts\PluginServiceProvider as BaseServiceProvider;
use Juzaweb\Contracts\ActivatorInterface;
use Juzaweb\Contracts\RepositoryInterface;
use Juzaweb\Exceptions\InvalidActivatorClass;
use Juzaweb\Support\LaravelFileRepository;
use Juzaweb\Support\Stub;

class PluginServiceProvider extends BaseServiceProvider
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
        $this->registerProviders();
        $this->registerServices();
        $this->setupStubPath();
    }

    /**
     * Setup stub path.
     */
    public function setupStubPath()
    {
        Stub::setBasePath(JW_PACKAGE_PATH . '/stubs/plugin');
    }

    /**
     * {@inheritdoc}
     */
    protected function registerServices()
    {
        $this->app->singleton(
            RepositoryInterface::class,
            function ($app) {
                $path = config('juzaweb.plugin.path');
    
                return new LaravelFileRepository($app, $path);
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

        $this->app->alias(RepositoryInterface::class, 'plugins');
    }
}
