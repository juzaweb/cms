<?php

namespace Juzaweb\Abstracts;

use Composer\Autoload\ClassLoader;
use Illuminate\Cache\CacheManager;
use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Macroable;
use Juzaweb\Contracts\ActivatorInterface;
use Juzaweb\Support\Json;

abstract class Plugin
{
    use Macroable;

    /**
     * The laravel|lumen application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * The plugin name.
     *
     * @var
     */
    protected $name;

    /**
     * The plugin path.
     *
     * @var string
     */
    protected $path;

    /**
     * @var array of cached Json objects, keyed by filename
     */
    protected $moduleJson = [];
    /**
     * @var CacheManager
     */
    private $cache;
    /**
     * @var Filesystem
     */
    private $files;

    /**
     * @var ActivatorInterface
     */
    protected $activator;

    /**
     * @var \Illuminate\Routing\Router
     */
    private $router;

    /**
     * The constructor.
     * @param Container $app
     * @param $name
     * @param $path
     */
    public function __construct(Container $app, string $name, $path)
    {
        $this->name = $name;
        $this->path = $path;
        $this->cache = $app['cache'];
        $this->files = $app['files'];
        $this->router = $app['router'];
        $this->activator = $app[ActivatorInterface::class];
        $this->app = $app;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get name in lower case.
     *
     * @return string
     */
    public function getLowerName(): string
    {
        return strtolower($this->name);
    }

    /**
     * Get name in studly case.
     *
     * @return string
     */
    public function getStudlyName(): string
    {
        $name = explode('/', $this->name);
        $author = Str::studly($name[0]);
        $module = Str::studly($name[1]);

        return $author .'/'. $module;
    }

    /**
     * Get name in snake case.
     *
     * @return string
     */
    public function getSnakeName(): string
    {
        return namespace_snakename($this->name);
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->get('description');
    }

    /**
     * Get alias.
     *
     * @return string
     */
    public function getAlias(): string
    {
        return $this->get('alias');
    }

    /**
     * Get priority.
     *
     * @return string
     */
    public function getPriority(): string
    {
        return $this->get('priority');
    }

    /**
     * Get plugin requirements.
     *
     * @return array
     */
    public function getRequires(): array
    {
        return $this->get('require', []);
    }

    /**
     * Get path.
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Set path.
     *
     * @param string $path
     *
     * @return $this
     */
    public function setPath($path): Plugin
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Bootstrap the application events.
     */
    public function boot(): void
    {
        if ($this->isLoadFilesOnBoot()) {
            //$this->registerFiles();
        }

        $this->fireEvent('boot');
    }

    /**
     * Get json contents from the cache, setting as needed.
     *
     * @param string $file
     *
     * @return Json
     */
    public function json($file = null): Json
    {
        if ($file === null) {
            $file = 'composer.json';
        }

        return Arr::get($this->moduleJson, $file, function () use ($file) {
            return $this->moduleJson[$file] = new Json($this->getPath() . '/' . $file, $this->files);
        });
    }

    /**
     * Get a specific data from json file by given the key.
     *
     * @param string $key
     * @param null $default
     *
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return $this->json()->get($key, $default);
    }

    /**
     * Get a specific data from composer.json file by given the key.
     *
     * @param $key
     * @param null $default
     *
     * @return mixed
     */
    public function getComposerAttr($key, $default = null)
    {
        return $this->json('composer.json')->get($key, $default);
    }

    /**
     * Register the plugin.
     */
    public function register(): void
    {
        if (config('plugin.autoload')) {
            $this->autoloadPSR4();
        }
        
        $this->registerAliases();

        $this->registerProviders();

        if ($this->isLoadFilesOnBoot() === false) {
            //$this->registerFiles();
        }

        $this->fireEvent('register');
    }

    /**
     * Register the plugin event.
     *
     * @param string $event
     */
    protected function fireEvent($event): void
    {
        $this->app['events']->dispatch(sprintf('plugin.%s.' . $event, $this->getLowerName()), [$this]);
    }
    
    protected function autoloadPSR4()
    {
        $loadmaps = $this->activator->getAutoloadInfo($this);
        $loader = new ClassLoader();
        foreach ($loadmaps as $loadmap) {
            $loader->setPsr4($loadmap['namespace'], [$loadmap['path']]);
        }
        $loader->register(true);
    }

    /**
     * Register the aliases from this plugin.
     */
    abstract public function registerAliases(): void;

    /**
     * Register the service providers from this plugin.
     */
    abstract public function registerProviders(): void;

    /**
     * Get the path to the cached *_module.php file.
     *
     * @return string
     */
    abstract public function getCachedServicesPath(): string;

    /**
     * Register the files from this plugin.
     */
    protected function registerFiles(): void
    {
        $files = Arr::get($this->get('autoload', []), 'files', []);
        foreach ($files as $file) {
            include $this->path . '/' . $file;
        }
    }

    /**
     * Handle call __toString.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getStudlyName();
    }

    /**
     * Determine whether the given status same with the current plugin status.
     *
     * @param bool $status
     *
     * @return bool
     */
    public function isStatus(bool $status): bool
    {
        return $this->activator->hasStatus($this, $status);
    }

    /**
     * Determine whether the current plugin activated.
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->activator->hasStatus($this, true);
    }

    /**
     *  Determine whether the current plugin not disabled.
     *
     * @return bool
     */
    public function isDisabled(): bool
    {
        return ! $this->isEnabled();
    }

    /**
     * Set active state for current plugin.
     *
     * @param bool $active
     *
     * @return bool
     */
    public function setActive(bool $active): bool
    {
        return $this->activator->setActive($this, $active);
    }

    /**
     * Disable the current plugin.
     */
    public function disable(): void
    {
        $this->fireEvent('disabling');

        $this->activator->disable($this);
        $this->flushCache();

        $this->fireEvent('disabled');
    }

    /**
     * Enable the current plugin.
     */
    public function enable(): void
    {
        $this->fireEvent('enabling');
        $this->activator->enable($this);
        $this->flushCache();
        $this->fireEvent('enabled');
    }

    /**
     * Delete the current plugin.
     *
     * @return bool
     */
    public function delete(): bool
    {
        $this->activator->delete($this);

        return $this->json()->getFilesystem()->deleteDirectory($this->getPath());
    }

    /**
     * Get extra path.
     *
     * @param string $path
     *
     * @return string
     */
    public function getExtraPath(string $path): string
    {
        return $this->getPath() . '/' . $path;
    }

    /**
     * Check if can load files of plugin on boot method.
     *
     * @return bool
     */
    protected function isLoadFilesOnBoot(): bool
    {
        return false;
    }

    protected function flushCache(): void
    {
        if (config('plugin.cache.enabled')) {
            $this->cache->store()->flush();
        }
        
        $this->cache->store('file')->pull(cache_prefix("site_actions"));
    }

    public function getExtraLarevel($key, $default = null): array
    {
        $extra = $this->get('extra', []);
        if ($laravel = Arr::get($extra, 'laravel', [])) {
            return Arr::get($laravel, $key, $default);
        }

        return $default;
    }

    public function getExtraJuzaweb($key, $default = null)
    {
        $extra = $this->get('extra', []);
        if ($laravel = Arr::get($extra, 'juzaweb', [])) {
            return Arr::get($laravel, $key, $default);
        }

        return $default;
    }

    public function getDisplayName()
    {
        $name = $this->getExtraJuzaweb('name');
        if (empty($name)) {
            $name = $this->get('name');
        }
        return $name;
    }

    public function getDomainName()
    {
        return $this->getExtraJuzaweb('domain');
    }

    public function getNamespace()
    {
        $namespace = Arr::get($this->get('autoload', []), 'psr-4');
        $namespace = array_keys($namespace);
        $namespace = $namespace[count($namespace) - 1];
        return $namespace;
    }

    public function getVersion()
    {
        return $this->getExtraJuzaweb('version', 0);
    }

    public function getSettingUrl()
    {
        $settingUrl = $this->getExtraJuzaweb('setting_url');
        return $settingUrl;
    }

    private function runMigrate()
    {
        Artisan::call('plugin:migrate', [
            'module' => $this->name,
            '--force' => true,
        ]);
    }

    public function publishAssets()
    {
        Artisan::call('plugin:publish', [
            'module' => $this->get('name'),
        ]);
    }
}
