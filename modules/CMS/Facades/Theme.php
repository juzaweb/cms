<?php

namespace Juzaweb\CMS\Facades;

use Illuminate\Support\Facades\Facade;
use Juzaweb\CMS\Contracts\ThemeContract;

/**
 * @method static set(string $theme)
 * @method static has(string $theme)
 * @method static getThemePath(string $theme = null, $path = '')
 * @method static \Illuminate\Support\Collection getThemeInfo(string $theme)
 * @method static getScreenshot(string $theme)
 * @method static get(string $theme)
 * @method static assets(string $path, $theme = null, $secure = null)
 * @method static publicPath(string $theme)
 * @method static getVersion(string $theme)
 * @method static array getRegister(string $theme)
 * @method static array getTemplates(string $theme, string $template = null)
 * @method static \Noodlehaus\Config[] all($assoc = false)
 *
 * @see \Juzaweb\CMS\Support\Theme\Theme
 */
class Theme extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ThemeContract::class;
    }
}
