<?php

namespace Juzaweb\Abstracts;

use Countable;
use Illuminate\Cache\CacheManager;
use Illuminate\Container\Container;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Macroable;
use Juzaweb\Contracts\RepositoryInterface;
use Juzaweb\Exceptions\InvalidAssetPath;
use Juzaweb\Exceptions\ModuleNotFoundException;
use Juzaweb\Support\Collection;
use Juzaweb\Support\Json;
use Juzaweb\Support\Process\Installer;
use Juzaweb\Support\Process\Updater;

abstract class FileRepository implements RepositoryInterface, Countable
{
    use Macroable;

    /**
     * Application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * The plugin path.
     *
     * @var string|null
     */
    protected $path;

    /**
     * The scanned paths.
     *
     * @var array
     */
    protected $paths = [];

    /**
     * @var string
     */
    protected $stubPath;
    /**
     * @var UrlGenerator
     */
    private $url;
    /**
     * @var ConfigRepository
     */
    private $config;
    /**
     * @var Filesystem
     */
    private $files;
    /**
     * @var CacheManager
     */
    private $cache;

    /**
     * The constructor.
     * @param Container $app
     * @param string|null $path
     */
    public function __construct(Container $app, $path = null)
    {
        $this->app = $app;
        $this->path = $path;
        $this->url = $app['url'];
        $this->config = $app['config'];
        $this->files = $app['files'];
        $this->cache = $app['cache'];
    }

    /**
     * Add other plugin location.
     *
     * @param string $path
     *
     * @return $this
     */
    public function addLocation($path)
    {
        $this->paths[] = $path;

        return $this;
    }

    /**
     * Get all additional paths.
     *
     * @return array
     */
    public function getPaths(): array
    {
        return $this->paths;
    }

    /**
     * Get scanned plugins paths.
     *
     * @return array
     */
    public function getScanPaths(): array
    {
        $paths = $this->paths;

        $paths[] = $this->getPath() . '/*';

        if (false) {
            $scanPaths = [
                base_path('vendor/*/*'),
            ];
            $paths = array_merge($paths, $scanPaths);
        }

        $paths = array_map(function ($path) {
            return Str::endsWith($path, '/*') ? $path : Str::finish($path, '/*');
        }, $paths);

        return $paths;
    }

    /**
     * Creates a new Plugin instance
     *
     * @param Container $app
     * @param string $args
     * @param string $path
     * @return \Juzaweb\Abstracts\Plugin
     */
    abstract protected function createModule(...$args);

    /**
     * Get & scan all plugins.
     *
     * @return array
     */
    public function scan()
    {
        $paths = $this->getScanPaths();

        $modules = [];

        foreach ($paths as $key => $path) {
            $manifests = $this->getFiles()->glob("{$path}/composer.json");

            is_array($manifests) || $manifests = [];

            foreach ($manifests as $manifest) {
                $info = Json::make($manifest)->getAttributes();
                $name = Arr::get($info, 'name');
                $modules[$name] = $this->createModule(
                    $this->app,
                    $name,
                    dirname($manifest)
                );
            }
        }

        return $modules;
    }

    /**
     * Get all plugins.
     *
     * @return array
     */
    public function all(): array
    {
        if (! $this->config('cache.enabled')) {
            return $this->scan();
        }

        return $this->formatCached($this->getCached());
    }

    /**
     * Format the cached data as array of plugins.
     *
     * @param array $cached
     *
     * @return array
     */
    protected function formatCached($cached)
    {
        $modules = [];
        foreach ($cached as $name => $module) {
            $path = $module['path'];
            $modules[$name] = $this->createModule($this->app, $name, $path);
        }

        return $modules;
    }

    /**
     * Get cached plugins.
     *
     * @return array
     */
    public function getCached()
    {
        return $this->cache->remember($this->config('cache.key'), $this->config('cache.lifetime'), function () {
            return $this->toCollection()->toArray();
        });
    }

    /**
     * Get all plugins as collection instance.
     *
     * @return Collection
     */
    public function toCollection(): Collection
    {
        return new Collection($this->scan());
    }

    /**
     * Get plugins by status.
     *
     * @param $status
     *
     * @return array
     */
    public function getByStatus($status): array
    {
        $modules = [];

        /** @var Plugin $module */
        foreach ($this->all() as $name => $module) {
            if ($module->isStatus($status)) {
                $modules[$name] = $module;
            }
        }

        return $modules;
    }

    /**
     * Determine whether the given plugin exist.
     *
     * @param $name
     *
     * @return bool
     */
    public function has($name): bool
    {
        return array_key_exists($name, $this->all());
    }

    /**
     * Get list of enabled plugins.
     *
     * @return array
     */
    public function allEnabled(): array
    {
        return $this->getByStatus(true);
    }

    /**
     * Get list of disabled plugins.
     *
     * @return array
     */
    public function allDisabled(): array
    {
        return $this->getByStatus(false);
    }

    /**
     * Get count from all plugins.
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->all());
    }

    /**
     * Get all ordered plugins.
     *
     * @param string $direction
     *
     * @return array
     */
    public function getOrdered($direction = 'asc'): array
    {
        $modules = $this->allEnabled();

        uasort($modules, function (Plugin $a, Plugin $b) use ($direction) {
            if ($a->get('order') === $b->get('order')) {
                return 0;
            }

            if ($direction === 'desc') {
                return $a->get('order') < $b->get('order') ? 1 : -1;
            }

            return $a->get('order') > $b->get('order') ? 1 : -1;
        });

        return $modules;
    }

    /**
     * @inheritDoc
     */
    public function getPath(): string
    {
        return $this->path ?: base_path('plugins');
    }

    /**
     * @inheritDoc
     */
    public function register(): void
    {
        foreach ($this->getOrdered() as $module) {
            $module->register();
        }
    }

    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        foreach ($this->getOrdered() as $module) {
            $module->boot();
        }
    }

    /**
     * @inheritDoc
     */
    public function find($name)
    {
        foreach ($this->all() as $module) {
            if ($module->getLowerName() === strtolower($name)) {
                return $module;
            }
        }

        return;
    }

    /**
     * @inheritDoc
     */
    public function findByAlias($alias)
    {
        foreach ($this->all() as $module) {
            if ($module->getAlias() === $alias) {
                return $module;
            }
        }

        return;
    }

    /**
     * @inheritDoc
     */
    public function findRequirements($name): array
    {
        $requirements = [];

        $module = $this->findOrFail($name);

        foreach ($module->getRequires() as $requirementName) {
            $requirements[] = $this->findByAlias($requirementName);
        }

        return $requirements;
    }

    /**
     * Find a specific module, if there return that, otherwise throw exception.
     *
     * @param $name
     *
     * @return Plugin
     *
     * @throws ModuleNotFoundException
     */
    public function findOrFail($name)
    {
        $module = $this->find($name);

        if ($module !== null) {
            return $module;
        }

        throw new ModuleNotFoundException("Plugin [{$name}] does not exist!");
    }

    /**
     * Get all modules as laravel collection instance.
     *
     * @param $status
     *
     * @return Collection
     */
    public function collections($status = 1): Collection
    {
        return new Collection($this->getByStatus($status));
    }

    /**
     * Get module path for a specific module.
     *
     * @param $module
     *
     * @return string
     */
    public function getModulePath($module)
    {
        try {
            return $this->findOrFail($module)->getPath() . '/';
        } catch (ModuleNotFoundException $e) {
            $name = Str::lower($module);
            $name = explode('/', $name)[1];
            return $this->getPath() . '/' . $name . '/';
        }
    }

    /**
     * @inheritDoc
     */
    public function assetPath($module): string
    {
        return public_path('jw-styles/plugins') . '/' . $module;
    }

    /**
     * @inheritDoc
     */
    public function config($key, $default = null)
    {
        return $this->config->get('plugin.' . $key, $default);
    }

    /**
     * Get storage path for module used.
     *
     * @return string
     */
    public function getUsedStoragePath(): string
    {
        $directory = storage_path('app/modules');
        if ($this->getFiles()->exists($directory) === false) {
            $this->getFiles()->makeDirectory($directory, 0777, true);
        }

        $path = storage_path('app/modules/plugin.used');
        if (! $this->getFiles()->exists($path)) {
            $this->getFiles()->put($path, '');
        }

        return $path;
    }

    /**
     * Set module used for cli session.
     *
     * @param $name
     *
     * @throws ModuleNotFoundException
     */
    public function setUsed($name)
    {
        $module = $this->findOrFail($name);

        $this->getFiles()->put($this->getUsedStoragePath(), $module);
    }

    /**
     * Forget the module used for cli session.
     */
    public function forgetUsed()
    {
        if ($this->getFiles()->exists($this->getUsedStoragePath())) {
            $this->getFiles()->delete($this->getUsedStoragePath());
        }
    }

    /**
     * Get module used for cli session.
     * @return string
     * @throws \Juzaweb\Exceptions\ModuleNotFoundException
     */
    public function getUsedNow(): string
    {
        return $this->findOrFail(
            $this->getFiles()
                ->get($this->getUsedStoragePath())
        );
    }

    /**
     * Get laravel filesystem instance.
     *
     * @return Filesystem
     */
    public function getFiles(): Filesystem
    {
        return $this->files;
    }

    /**
     * Get module assets path.
     *
     * @return string
     */
    public function getAssetsPath(): string
    {
        return public_path('plugins');
    }

    /**
     * Get asset url from a specific module.
     * @param string $asset
     * @return string
     * @throws InvalidAssetPath
     */
    public function asset($asset): string
    {
        if (Str::contains($asset, ':') === false) {
            throw InvalidAssetPath::missingModuleName($asset);
        }
        list($name, $url) = explode(':', $asset);

        $baseUrl = str_replace(public_path() . DIRECTORY_SEPARATOR, '', $this->getAssetsPath());

        $url = $this->url->asset($baseUrl . "/{$name}/" . $url);

        return str_replace(['http://', 'https://'], '//', $url);
    }

    /**
     * @inheritDoc
     */
    public function isEnabled($name): bool
    {
        return $this->findOrFail($name)->isEnabled();
    }

    /**
     * @inheritDoc
     */
    public function isDisabled($name): bool
    {
        return ! $this->isEnabled($name);
    }

    /**
     * Enabling a specific module.
     * @param string $name
     * @return void
     * @throws \Juzaweb\Exceptions\ModuleNotFoundException
     */
    public function enable($name)
    {
        $this->findOrFail($name)->enable();
    }

    /**
     * Disabling a specific module.
     * @param string $name
     * @return void
     * @throws \Juzaweb\Exceptions\ModuleNotFoundException
     */
    public function disable($name)
    {
        $this->findOrFail($name)->disable();
    }

    /**
     * @inheritDoc
     */
    public function delete($name): bool
    {
        return $this->findOrFail($name)->delete();
    }

    /**
     * Update dependencies for the specified module.
     *
     * @param string $module
     */
    public function update($module)
    {
        with(new Updater($this))->update($module);
    }

    /**
     * Install the specified module.
     *
     * @param string $name
     * @param string $version
     * @param string $type
     * @param bool   $subtree
     *
     * @return \Symfony\Component\Process\Process
     */
    public function install($name, $version = 'dev-master', $type = 'composer', $subtree = false)
    {
        $installer = new Installer($name, $version, $type, $subtree);

        return $installer->run();
    }

    /**
     * Get stub path.
     *
     * @return string|null
     */
    public function getStubPath()
    {
        if ($this->stubPath !== null) {
            return $this->stubPath;
        }

        if ($this->config('stubs.enabled') === true) {
            return $this->config('stubs.path');
        }

        return $this->stubPath;
    }

    /**
     * Set stub path.
     *
     * @param string $stubPath
     *
     * @return $this
     */
    public function setStubPath($stubPath)
    {
        $this->stubPath = $stubPath;

        return $this;
    }
}
