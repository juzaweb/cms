<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Support;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    protected static $actions = [];

    /**
     * Register Action.
     *
     * @param  string|array $actions
     * @return void
     */
    protected function registerAction($actions)
    {
        //static::$actions = array_merge(static::$actions, $actions);
    }
}
