<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Facades;

use Illuminate\Support\Facades\Facade;
use Juzaweb\CMS\Contracts\ThemeConfigContract;

/**
 * @method static mixed setConfig($key, $value)
 * @method static string|array getConfig($key, $default)
 *
 * @see \Juzaweb\CMS\Support\Theme\ThemeConfig
 */
class ThemeConfig extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return ThemeConfigContract::class;
    }
}
