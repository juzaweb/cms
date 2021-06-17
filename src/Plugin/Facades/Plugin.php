<?php

namespace Tadcms\Modules\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static Plugin[] all()
 * @method static delete($plugin)
 * @method static enable($plugin)
 * @method static disable($plugin)
 * @method get(string $key, $default = null)
 * @method getDisplayName()
 * @method bool isEnabled()
 * @see \Tadcms\Modules\Laravel\Module
 * */
class Plugin extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'modules';
    }
}
