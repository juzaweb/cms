<?php

namespace Juzaweb\CMS\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static Plugin[] all()
 * @method static Plugin|null find(string $name)
 * @method static delete(string $plugin)
 * @method static enable(string $plugin)
 * @method static disable(string $plugin)
 * @method static getPath(string $path = '')
 * @method get(string $key, $default = null)
 * @method string getDisplayName()
 * @method string getDomainName()
 * @method string getSettingUrl()
 * @method string getVersion()
 * @method string getScreenshot()
 * @method bool isEnabled()
 *
 * @see \Juzaweb\CMS\Support\LocalPluginRepository
 */
class Plugin extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'plugins';
    }
}
