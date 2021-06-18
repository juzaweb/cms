<?php

namespace Mymo\Plugin;

use Mymo\Plugin\Contracts\RepositoryInterface;
use Mymo\Plugin\Exceptions\InvalidActivatorClass;
use Mymo\Plugin\Support\Stub;
use Composer\Autoload\ClassLoader;

class PluginServiceProvider extends ModulesServiceProvider
{
    /**
     * Booting the package.
     */
    public function boot()
    {
        $this->registerNamespaces();
        $this->registerModules();
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->pluginAutoload();
        $this->registerServices();
        $this->setupStubPath();
        $this->registerProviders();
    }

    /**
     * Setup stub path.
     */
    public function setupStubPath()
    {
        Stub::setBasePath(__DIR__ . '/../../stubs/plugin');

        /*$this->app->booted(function ($app) {
            $moduleRepository = $app[RepositoryInterface::class];
            Stub::setBasePath($moduleRepository->config('stubs.path'));
        });*/
    }

    /**
     * {@inheritdoc}
     */
    protected function registerServices()
    {
        $this->app->singleton(Contracts\RepositoryInterface::class, function ($app) {
            $path = $app['config']->get('plugin.paths.modules');

            return new Laravel\LaravelFileRepository($app, $path);
        });
        $this->app->singleton(Contracts\ActivatorInterface::class, function ($app) {
            $activator = $app['config']->get('plugin.activator');
            $class = $app['config']->get('plugin.activators.' . $activator)['class'];

            if ($class === null) {
                throw InvalidActivatorClass::missingConfig();
            }

            return new $class($app);
        });
        $this->app->alias(Contracts\RepositoryInterface::class, 'modules');
    }

    protected function pluginAutoload()
    {
        $pluginFile = base_path('bootstrap/cache/plugins_statuses.php');
        if (!file_exists($pluginFile)) {
            return;
        }

        $plugins = require $pluginFile;
        if (empty($plugins)) {
            return;
        }

        $pluginsFolder = base_path('plugins');

        $loader = new ClassLoader();
        foreach ($plugins as $pluginInfo) {
            foreach ($pluginInfo as $key => $item) {
                $path = $pluginsFolder . '/' . $item['path'];
                $namespace = $item['namespace'] ?? '';
                if (is_dir($path) && $namespace) {
                    $loader->setPsr4($namespace, [$path]);
                }
            }
        }

        $loader->register(true);
    }
}
