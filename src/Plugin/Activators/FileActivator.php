<?php

namespace Tadcms\Modules\Activators;

use Illuminate\Cache\CacheManager;
use Illuminate\Config\Repository as Config;
use Illuminate\Container\Container;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Tadcms\Modules\Contracts\ActivatorInterface;
use Tadcms\Modules\Exceptions\ModuleNotFoundException;
use Tadcms\Modules\Plugin;

class FileActivator implements ActivatorInterface
{
    /**
     * Laravel cache instance
     *
     * @var CacheManager
     */
    private $cache;

    /**
     * Laravel Filesystem instance
     *
     * @var Filesystem
     */
    private $files;

    /**
     * Laravel config instance
     *
     * @var Config
     */
    private $config;

    /**
     * @var string
     */
    private $cacheKey;

    /**
     * @var string
     */
    private $cacheLifetime;

    /**
     * Array of plugins activation statuses
     *
     * @var array
     */
    private $modulesStatuses;

    /**
     * File used to store activation statuses
     *
     * @var string
     */
    private $statusesFile;

    public function __construct(Container $app)
    {
        $this->cache = $app['cache'];
        $this->files = $app['files'];
        $this->config = $app['config'];
        $this->statusesFile = $this->config('statuses-file');
        $this->cacheKey = $this->config('cache-key');
        $this->cacheLifetime = $this->config('cache-lifetime');
        $this->modulesStatuses = $this->getModulesStatuses();
    }

    /**
     * Get the path of the file where statuses are stored
     *
     * @return string
     */
    public function getStatusesFilePath(): string
    {
        return $this->statusesFile;
    }

    /**
     * @inheritDoc
     */
    public function reset(): void
    {
        if ($this->files->exists($this->statusesFile)) {
            $this->files->delete($this->statusesFile);
        }
        $this->modulesStatuses = [];
        $this->flushCache();
    }

    /**
     * @inheritDoc
     */
    public function enable(Plugin $module): void
    {
        $this->setActiveByName($module->getName(), true);
    }

    /**
     * @inheritDoc
     */
    public function disable(Plugin $module): void
    {
        $this->setActiveByName($module->getName(), false);
    }

    /**
     * @inheritDoc
     */
    public function hasStatus(Plugin $module, bool $status): bool
    {
        if (!isset($this->modulesStatuses[$module->getName()])) {
            return $status === false;
        }

        return $status === true;
    }

    /**
     * @inheritDoc
     */
    public function setActive(Plugin $module, bool $active): void
    {
        $this->setActiveByName($module->getName(), $active);
    }

    /**
     * @inheritDoc
     */
    public function setActiveByName(string $name, bool $status): void
    {
        if ($status) {
            $pluginFile = base_path('plugins') . '/' . $name . '/composer.json';
            $setting = @json_decode($this->files->get($pluginFile), true);

            if (isset($setting['autoload']['psr-4'])) {
                $psr4 = $setting['autoload']['psr-4'];
                $classMap = [];

                foreach ($psr4 as $key => $path) {
                    if ($path[strlen($path) - 1] == '/') {
                        $path = rtrim($path, '/');
                    }

                    $classMap[] = [
                        'namespace' => $key,
                        'path' => $name . '/' . $path
                    ];
                }

                $this->modulesStatuses[$name] = $classMap;
            } else {
                throw new ModuleNotFoundException("Plugin ". $name . " does not exists.");
            }

        } else {
            unset($this->modulesStatuses[$name]);
        }

        $this->writeJson();
        $this->flushCache();
    }

    /**
     * @inheritDoc
     */
    public function delete(Plugin $module): void
    {
        if (!isset($this->modulesStatuses[$module->getName()])) {
            return;
        }
        unset($this->modulesStatuses[$module->getName()]);
        $this->writeJson();
        $this->flushCache();
    }

    /**
     * Writes the activation statuses in a file, as json
     */
    private function writeJson(): void
    {
        $str = '<?php

return ' . var_export($this->modulesStatuses, true) .';

';
        $this->files->put($this->statusesFile, $str);
    }

    /**
     * Reads the json file that contains the activation statuses.
     * @return array
     * @throws FileNotFoundException
     */
    private function readJson(): array
    {
        if (!$this->files->exists($this->statusesFile)) {
            return [];
        }

        return (require $this->statusesFile);
    }

    /**
     * Get plugins statuses, either from the cache or from
     * the json statuses file if the cache is disabled.
     * @return array
     * @throws FileNotFoundException
     */
    private function getModulesStatuses(): array
    {
        if (!$this->config->get('modules.cache.enabled')) {
            return $this->readJson();
        }

        return $this->cache->remember($this->cacheKey, $this->cacheLifetime, function () {
            return $this->readJson();
        });
    }

    /**
     * Reads a config parameter under the 'activators.file' key
     *
     * @param  string $key
     * @param  $default
     * @return mixed
     */
    private function config(string $key, $default = null)
    {
        return $this->config->get('modules.activators.file.' . $key, $default);
    }

    /**
     * Flushes the plugins activation statuses cache
     */
    private function flushCache(): void
    {
        $this->cache->forget($this->cacheKey);
    }
}
