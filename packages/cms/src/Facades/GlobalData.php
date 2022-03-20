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
use Juzaweb\Contracts\GlobalDataContract;

/**
 * @method static void set($key, $value)
 * @method static void push($key, $value)
 * @method static void registerAction(array $actions)
 * @method static void initAction()
 * @method static mixed get($key)
 * @see \Juzaweb\Support\GlobalData
 */
class GlobalData extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return GlobalDataContract::class;
    }
}
