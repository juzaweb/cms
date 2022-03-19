<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Facades;

use Illuminate\Support\Facades\Facade;
use Juzaweb\Contracts\ThemeConfigContract;

/**
 * @method static mixed setConfig($key, $value)
 * @method static string|array getConfig($key, $default)
 *
 * @see \Juzaweb\Support\Theme\ThemeConfig
 */
class ThemeConfig extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ThemeConfigContract::class;
    }
}
