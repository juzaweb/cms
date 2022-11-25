<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\CMS\Support\Manager;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Juzaweb\CMS\Contracts\TranslationManager as TranslationManagerContract;
use Juzaweb\CMS\Facades\Plugin;
use Juzaweb\CMS\Facades\ThemeLoader;
use Juzaweb\CMS\Models\Translation;
use Symfony\Component\Finder\SplFileInfo;

class TranslationManager implements TranslationManagerContract
{
    public function importFormFiles()
    {
        $this->importTranslateFiles();

        $themes = $this->getLocaleThemes();
        foreach ($themes as $theme) {
            $this->manager->findTranslations(
                base_path("themes/{$theme->get('name')}"),
                $theme->get('key'),
                $theme->get('type')
            );
        }
    }

    protected function allObjects(): Collection
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

        return collect(array_merge($result, $this->getLocalePlugins()));
    }

    protected function getLocalePlugins(): array
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

    protected function getLocaleThemes(): array
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

    protected function originPath($key, $path = ''): string
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
     * @return string|Collection
     */
    protected function parseVar(Collection|string $key): string|Collection
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

    protected function importTranslateFiles()
    {
        $objects = $this->allObjects();
        foreach ($objects as $key => $object) {
            $locales = $this->allLanguageOrigin($key);
            foreach ($locales as $locale) {
                $result = $this->getAllTrans(
                    $object->get('key'),
                    $locale['code']
                );

                foreach ($result as $item) {
                    Translation::firstOrCreate(
                        [
                            'locale' => $locale['code'],
                            'group' => $item['group'],
                            'namespace' => $object->get('namespace'),
                            'key' => $item['key'],
                            'object_type' => $object->get('type'),
                            'object_key' => $object->get('key'),
                        ],
                        [
                            'value' => $item['value']
                        ]
                    );
                }
            }
        }
    }

    /**
     * Get all language trans
     *
     * @param string|Collection $key
     * @param string $locale
     * @return array
     */
    protected function getAllTrans(string|Collection $key, string $locale): array
    {
        $key = $this->parseVar($key);
        $files = File::files($this->originPath($key, $locale));
        $files = collect($files)
            ->filter(
                function (SplFileInfo $item) {
                    return $item->getExtension() == 'php';
                }
            )
            ->values()
            ->toArray();

        $result = [];
        foreach ($files as $file) {
            $lang = require($file->getRealPath());
            $group = str_replace('.php', '', $file->getFilename());
            $this->mapGroupKeys($lang, $group, $result);
        }

        return $result;
    }

    /**
     * Get all language from data plugin/theme/core
     *
     * @param Collection|string $key
     * @return array
     */
    protected function allLanguageOrigin(Collection|string $key): array
    {
        $folderPath = $this->originPath($key);
        if (!is_dir($folderPath)) {
            return [];
        }

        $folders = File::directories($folderPath);
        $folders = collect($folders)
            ->map(fn ($item) => basename($item))
            ->values()
            ->toArray();

        return collect(config('locales'))
            ->whereIn('code', $folders)
            ->toArray();
    }

    protected function mapGroupKeys(array $lang, $group, &$result, $keyPrefix = '')
    {
        foreach ($lang as $key => $item) {
            if (is_array($item)) {
                $keyPrefix .= "{$key}.";
                $this->mapGroupKeys($item, $group, $result, $keyPrefix);
            } else {
                $result[] = [
                    'key' => $keyPrefix . $key,
                    'value' => $item,
                    'group' => $group
                ];
            }
        }
    }
}
