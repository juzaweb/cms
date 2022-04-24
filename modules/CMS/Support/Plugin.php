<?php

namespace Juzaweb\CMS\Support;

use Composer\Autoload\ClassLoader;
use Illuminate\Cache\CacheManager;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\ProviderRepository;
use Illuminate\Routing\Router;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Macroable;
use Juzaweb\CMS\Contracts\ActivatorInterface;
use Illuminate\Contracts\Foundation\Application as ApplicationContract;

class Plugin
{
    use Macroable;

    protected ApplicationContract $app;

    protected string $name;

    /**
     * The plugin path.
     *
     * @var string
     */
    protected string $path;

    /**
     * @var array of cached Json objects, keyed by filename
     */
    protected array $moduleJson = [];
    /**
     * @var CacheManager
     */
    private CacheManager $cache;
    /**
     * @var Filesystem
     */
    private Filesystem $files;

    /**
     * @var ActivatorInterface
     */
    protected ActivatorInterface $activator;

    /**
     * @var Router
     */
    private Router $router;

    /**
     * The constructor.
     * @param ApplicationContract $app
     * @param string $name
     * @param string $path
     */
    public function __construct(ApplicationContract $app, string $name, string $path)
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
     * Get name plugin.
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

        return $author.'/'.$module;
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
    public function setPath(string $path): Plugin
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Bootstrap the application events.
     */
    public function boot(): void
    {
        $this->fireEvent('boot');
    }

    /**
     * Get json contents from the cache, setting as needed.
     *
     * @param string $file
     *
     * @return Json
     */
    public function json(string $file = null): Json
    {
        if ($file === null) {
            $file = 'composer.json';
        }

        return Arr::get(
            $this->moduleJson,
            $file,
            function () use ($file) {
                return $this->moduleJson[$file] = new Json($this->getPath().'/'.$file, $this->files);
            }
        );
    }

    /**
     * Get a specific data from json file by given the key.
     *
     * @param string $key
     * @param null $default
     *
     * @return mixed
     */
    public function get(string $key, $default = null): mixed
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
    public function getComposerAttr($key, $default = null): mixed
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

            $this->registerAliases();

            $this->registerProviders();
        }

        $this->registerFiles();

        $this->fireEvent('register');
    }

    /**
     * Register the plugin event.
     *
     * @param string $event
     */
    protected function fireEvent($event): void
    {
        $this->app['events']->dispatch(
            sprintf('plugin.%s.'.$event, $this->getLowerName()),
            [$this]
        );
    }

    protected function autoloadPSR4(): void
    {
        $loadmaps = $this->activator->getAutoloadInfo($this);
        $loader = new ClassLoader();

        foreach ($loadmaps as $loadmap) {
            if (empty($loadmap['namespace']) || empty($loadmap['path'])) {
                continue;
            }

            $loader->setPsr4($loadmap['namespace'], [$loadmap['path']]);
        }
        $loader->register(true);
    }

    /**
     * Get the path to the cached *_module.php file.
     */
    public function getCachedServicesPath(): string
    {
        return Str::replaceLast(
            'services.php',
            $this->getSnakeName().'_module.php',
            $this->app->getCachedServicesPath()
        );
    }

    /**
     * Register the service providers from this plugin.
     */
    public function registerProviders(): void
    {
        $providers = $this->getExtraJuzaweb('providers', []);

        if (config('plugin.autoload')) {
            $providers = array_merge(
                $this->getExtraLarevel('providers', []),
                $providers
            );
        }

        try {
            (new ProviderRepository(
                $this->app,
                new Filesystem(),
                $this->getCachedServicesPath()
            ))
                ->load($providers);
        } catch (\Throwable $e) {
            $this->disable();
            throw $e;
        }
    }

    /**
     * Register the aliases from this plugin.
     */
    public function registerAliases(): void
    {
        $loader = AliasLoader::getInstance();

        foreach ($this->getExtraJuzaweb('aliases', []) as $aliasName => $aliasClass) {
            $loader->alias($aliasName, $aliasClass);
        }
    }

    /**
     * Register the files from this plugin.
     */
    protected function registerFiles(): void
    {
        $files = Arr::get($this->get('autoload', []), 'files', []);
        foreach ($files as $file) {
            include $this->path.'/'.$file;
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
        return !$this->isEnabled();
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
        if (config('plugin.autoload')) {
            $this->runMigrate();
        }
        $this->publishAssets();
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
        return $this->getPath().'/'.$path;
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

        return $namespace[count($namespace) - 1];
    }

    public function getVersion()
    {
        return $this->getExtraJuzaweb('version', 0);
    }

    public function getSettingUrl(): ?string
    {
        return $this->getExtraJuzaweb('setting_url');
    }

    public function publishAssets(): void
    {
        Artisan::call(
            'plugin:publish',
            [
                'module' => $this->get('name'),
            ]
        );
    }

    protected function flushCache(): void
    {
        if (config('plugin.cache.enabled')) {
            $this->cache->store()->flush();
        }
    }

    protected function runMigrate(): void
    {
        Artisan::call(
            'plugin:migrate',
            [
                'module' => $this->name,
                '--force' => true,
            ]
        );
    }
}
