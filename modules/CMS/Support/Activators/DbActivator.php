<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Support\Activators;

use Illuminate\Cache\CacheManager;
use Illuminate\Config\Repository as Config;
use Illuminate\Container\Container;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Juzaweb\CMS\Contracts\ActivatorInterface;
use Juzaweb\CMS\Contracts\ConfigContract;
use Juzaweb\CMS\Exceptions\PluginNotFoundException;
use Juzaweb\CMS\Support\Plugin;

class DbActivator implements ActivatorInterface
{
    /**
     * Laravel cache instance
     *
     * @var CacheManager
     */
    private CacheManager $cache;

    /**
     * Laravel Filesystem instance
     *
     * @var Filesystem
     */
    private Filesystem $files;

    /**
     * Laravel config instance
     *
     * @var Config
     */
    private Config $config;

    private ConfigContract $dbConfig;

    /**
     * Array of plugins activation statuses
     *
     * @var array
     */
    private array $modulesStatuses;

    public function __construct(
        Container $app,
        ConfigContract $dbConfig
    ) {
        $this->cache = $app['cache'];
        $this->files = $app['files'];
        $this->config = $app['config'];
        $this->dbConfig = $dbConfig;
        $this->modulesStatuses = $this->getModulesStatuses();
    }

    /**
     * Enables a plugin
     *
     * @param Plugin $module
     * @throws PluginNotFoundException
     * @throws FileNotFoundException
     */
    public function enable(Plugin $module): void
    {
        $this->setActiveByName($module->getName(), true);
    }

    /**
     * Disables a plugin
     *
     * @param Plugin $module
     * @throws PluginNotFoundException
     * @throws FileNotFoundException
     */
    public function disable(Plugin $module): void
    {
        $this->setActiveByName($module->getName(), false);
    }

    /**
     * Determine whether the given status same with a plugin status.
     *
     * @param Plugin $module
     * @param bool $status
     *
     * @return bool
     */
    public function hasStatus(Plugin $module, $status): bool
    {
        if (! isset($this->modulesStatuses[$module->getName()])) {
            return $status === false;
        }

        return $status === true;
    }

    /**
     * Set active state for a plugin.
     *
     * @param Plugin $module
     * @param bool $active
     * @throws PluginNotFoundException
     * @throws FileNotFoundException
     */
    public function setActive(Plugin $module, $active): void
    {
        $this->setActiveByName($module, $active);
    }

    /**
     * Sets a plugin status by its name
     *
     * @param string $module
     * @param bool $active
     * @throws PluginNotFoundException
     * @throws FileNotFoundException
     */
    public function setActiveByName($module, $active): void
    {
        if ($active) {
            // $pluginPath = $module->getPath();
            // $pluginFile = $pluginPath . '/composer.json';
            // $setting = @json_decode(
            //     $this->files->get($pluginFile),
            //     true
            // );

            // if (isset($setting['autoload']['psr-4'])) {
            //     $psr4 = $setting['autoload']['psr-4'];
            //     $domain = $setting['extra']['juzaweb']['domain'] ?? '';
            //
            //     $classMap = [];
            //     foreach ($psr4 as $key => $paths) {
            //         if (!is_array($paths)) {
            //             $paths = [$paths];
            //         }
            //
            //         foreach ($paths as $path) {
            //             if ($path[strlen($path) - 1] == '/') {
            //                 $path = rtrim($path, '/');
            //             }
            //
            //             $classMap[] = [
            //                 'namespace' => $key,
            //                 'path' => $pluginPath . '/' . $path,
            //                 'domain' => $domain,
            //             ];
            //         }
            //     }
            //
            //     $this->modulesStatuses[$name] = $classMap;
            // } else {
            //     throw new PluginNotFoundException(
            //         "Plugin [". $name . "] does not exists."
            //     );
            // }

            $this->modulesStatuses[$module] = $module;
        } else {
            unset($this->modulesStatuses[$module]);
        }

        $this->writeData();
    }

    /**
     * Deletes a plugin activation status
     *
     * @param  Plugin $module
     */
    public function delete(Plugin $module): void
    {
        unset($this->modulesStatuses[$module->getName()]);
        $this->writeData();
    }

    /**
     * Get plugin info load
     *
     * @param  Plugin $module
     * @return ?array
     */
    public function getAutoloadInfo(Plugin $module): ?array
    {
        return $this->modulesStatuses[$module->getName()] ?? [];
    }

    /**
     * Deletes any plugin activation statuses created by this class.
     */
    public function reset(): void
    {
        $this->modulesStatuses = [];
        $this->writeData();
    }

    /**
     * Get plugins statuses, either from the cache or from
     * the json statuses file if the cache is disabled.
     * @return array
     */
    public function getModulesStatuses(): array
    {
        try {
            return $this->dbConfig->getConfig('plugin_statuses', []);
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Writes the activation statuses in a file, as json
     */
    private function writeData(): void
    {
        set_config('plugin_statuses', $this->modulesStatuses);
    }
}
