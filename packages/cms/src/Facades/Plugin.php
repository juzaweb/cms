<?php

namespace Juzaweb\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static Plugin[] all()
 * @method static delete(string $plugin)
 * @method static enable(string $plugin)
 * @method static disable(string $plugin)
 * @method static getPath()
 * @method get(string $key, $default = null)
 * @method getDisplayName()
 * @method getDomainName()
 * @method bool isEnabled()
 *
 * @see \Juzaweb\Support\Module
 */
class Plugin extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'plugins';
    }
}
