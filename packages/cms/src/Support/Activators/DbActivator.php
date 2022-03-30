<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Support\Activators;

use Illuminate\Cache\CacheManager;
use Illuminate\Config\Repository as Config;
use Illuminate\Container\Container;
use Juzaweb\Abstracts\Plugin;
use Juzaweb\Contracts\ActivatorInterface;
use Illuminate\Filesystem\Filesystem;
use Juzaweb\Exceptions\ModuleNotFoundException;

class DbActivator implements ActivatorInterface
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
     * Array of plugins activation statuses
     *
     * @var array
     */
    private $modulesStatuses;

    public function __construct(Container $app)
    {
        $this->cache = $app['cache'];
        $this->files = $app['files'];
        $this->config = $app['config'];
        $this->modulesStatuses = $this->getModulesStatuses();
    }
    /**
     * Enables a plugin
     *
     * @param Plugin $module
     */
    public function enable(Plugin $module): void
    {
        $this->setActiveByName($module->getName(), true);
    }

    /**
     * Disables a plugin
     *
     * @param Plugin $module
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
     */
    public function setActive(Plugin $module, $active): void
    {
        $this->setActiveByName($module->getName(), $active);
    }

    /**
     * Sets a plugin status by its name
     *
     * @param  string $name
     * @param  bool $active
     */
    public function setActiveByName($name, $active): void
    {
        if ($active) {
            $pluginPath = plugin_path($name);
            $pluginFile = $pluginPath . '/composer.json';
            $setting = @json_decode(
                $this->files->get($pluginFile),
                true
            );

            if (isset($setting['autoload']['psr-4'])) {
                $psr4 = $setting['autoload']['psr-4'];
                $domain = $setting['extra']['juzaweb']['domain'];
                $classMap = [];

                foreach ($psr4 as $key => $paths) {
                    if (!is_array($paths)) {
                        $paths = [$paths];
                    }

                    foreach ($paths as $path) {
                        if ($path[strlen($path) - 1] == '/') {
                            $path = rtrim($path, '/');
                        }

                        $classMap[] = [
                            'namespace' => $key,
                            'path' => $pluginPath . '/' . $path,
                            'domain' => $domain,
                        ];
                    }
                }

                $this->modulesStatuses[$name] = $classMap;
            } else {
                throw new ModuleNotFoundException("Plugin [". $name . "] does not exists.");
            }
        } else {
            unset($this->modulesStatuses[$name]);
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
     * @return array
     */
    public function getAutoloadInfo(Plugin $module): array
    {
        return $this->modulesStatuses[$module->getName()] ?? null;
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
            return get_config('plugin_statuses', []);
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
