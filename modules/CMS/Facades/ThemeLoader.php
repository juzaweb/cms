<?php

namespace Juzaweb\CMS\Facades;

use Illuminate\Support\Facades\Facade;
use Juzaweb\CMS\Contracts\ThemeLoaderContract;
use Noodlehaus\Config;

/**
 * @method static void set(string $theme)
 * @method static bool has(string $theme)
 * @method static string getPath(string $theme = null, $path = '')
 * @method static string getThemePath(string $theme = null, $path = '')
 * @method static bool|Config getInfo(string $theme)
 * @method static bool|Config getThemeInfo(string $theme)
 * @method static string getScreenshot(string $theme)
 * @method static mixed get(string $theme)
 * @method static string assets(string $path, $theme = null, $secure = null)
 * @method static string publicPath(string $theme)
 * @method static string getVersion(string $theme)
 * @method static array getRegister(string $theme)
 * @method static array getTemplates(string $theme, string $template = null)
 * @method static \Noodlehaus\Config[] all($assoc = false)
 *
 * @see \Juzaweb\CMS\Support\Theme\Theme
 */
class ThemeLoader extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return ThemeLoaderContract::class;
    }
}
