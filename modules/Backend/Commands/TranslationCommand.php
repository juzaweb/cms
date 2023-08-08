<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Commands;

use Illuminate\Console\Command;
use Juzaweb\CMS\Facades\Plugin;
use Juzaweb\CMS\Facades\ThemeLoader;
use Illuminate\Support\Collection;

abstract class TranslationCommand extends Command
{
    protected function allObjects()
    {
        $result = [];
        $result['core'] = collect(
            [
                'title' => 'Core Juzaweb',
                'key' => 'core',
                'type' => 'core',
                'namespace' => 'cms',
                'path' => 'modules/Backend/resources/lang'
            ]
        );

        $result = array_merge($result, $this->getLocalePlugins());

        return collect($result);
    }

    protected function getLocalePlugins()
    {
        $result = [];
        $plugins = Plugin::all();
        foreach ($plugins as $plugin) {
            $snakeName = namespace_snakename($plugin->get('name'));
            $result[$snakeName] = collect(
                [
                    'title' => $plugin->getDisplayName(),
                    'key' => $snakeName,
                    'namespace' => $plugin->getDomainName(),
                    'type' => 'plugin',
                    'path' => 'plugins/' . $plugin->get('name') . '/src/resources/lang'
                ]
            );
        }

        return $result;
    }

    protected function getLocaleThemes()
    {
        $result = [];
        $themes = ThemeLoader::all();
        foreach ($themes as $theme) {
            $result['theme_' . $theme->get('name')] = collect(
                [
                    'title' => $theme->get('title'),
                    'key' => 'theme_' . $theme->get('name'),
                    'name' => $theme->get('name'),
                    'type' => 'theme',
                    'namespace' => '*',
                    'path' => null,
                ]
            );
        }

        return $result;
    }

    protected function originPath($key, $path = '')
    {
        $key = $this->parseVar($key);
        $basePath = base_path($key->get('path'));

        if (empty($path)) {
            return $basePath;
        }

        return $basePath . '/' . $path;
    }

    /**
     * @param Collection|string $key
     * @return Collection
     */
    protected function parseVar($key)
    {
        if (is_a($key, Collection::class)) {
            return $key;
        }

        return $this->getByKey($key);
    }

    protected function getByKey(string $key)
    {
        return $this->allObjects()->get($key, []);
    }
}
