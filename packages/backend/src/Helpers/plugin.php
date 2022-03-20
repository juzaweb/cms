<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

if (! function_exists('plugin_path')) {
    function plugin_path($name, $path = '')
    {
        $module = app('plugins')->find($name);

        return $module->getPath() . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}

if (! function_exists('namespace_snakename')) {
    function namespace_snakename(string $namespace)
    {
        return Str::snake(preg_replace('/[^0-9a-z]/', ' ', strtolower($namespace)));
    }
}

if (! function_exists('installed_plugins')) {
    function installed_plugins()
    {
        $plugins = app('plugins')->all();

        return array_keys($plugins);
    }
}
