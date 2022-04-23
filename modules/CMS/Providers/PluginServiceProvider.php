<?php

namespace Juzaweb\CMS\Providers;

use Juzaweb\CMS\Abstracts\PluginServiceProvider as BaseServiceProvider;
use Juzaweb\CMS\Contracts\ActivatorInterface;
use Juzaweb\CMS\Contracts\PluginRepositoryInterface;
use Juzaweb\CMS\Exceptions\InvalidActivatorClass;
use Juzaweb\CMS\Support\LaravelFileRepository;
use Juzaweb\CMS\Support\Stub;

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
        Stub::setBasePath(__DIR__ . '/../stubs/plugin');
    }

    /**
     * {@inheritdoc}
     */
    protected function registerServices()
    {
        $this->app->singleton(
            PluginRepositoryInterface::class,
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

        $this->app->alias(PluginRepositoryInterface::class, 'plugins');
    }
}
