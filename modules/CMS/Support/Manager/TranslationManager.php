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
use Juzaweb\CMS\Contracts\LocalPluginRepositoryContract;
use Juzaweb\CMS\Contracts\TranslationManager as TranslationManagerContract;
use Juzaweb\CMS\Models\Translation;
use Juzaweb\CMS\Support\LocalThemeRepository;

class TranslationManager implements TranslationManagerContract
{
    public function __construct(
        protected LocalPluginRepositoryContract $pluginRepository,
        protected LocalThemeRepository $themeRepository
    ) {
    }

    public function import(string $name, string $module = 'cms')
    {
        $locales = $this->getLocalLocales($name, $module);
        foreach ($locales as $locale) {
            $result = $this->getLocalTranslates($name, $module, $locale['code']);

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

    public function export(string $name, string $module = 'cms')
    {
        //
    }

    public function translate(string $source, string $target, string $name, string $module = 'cms')
    {
        //
    }

    protected function getLocalLocales(string $name, string $module = 'cms'): array
    {
        $folderPath = $this->getModuleData($module, $name)->get('path');
        if (!is_dir($folderPath)) {
            return [];
        }

        $folders = collect(File::directories($folderPath))
            ->map(fn ($item) => basename($item))
            ->values()
            ->toArray();

        return collect(config('locales'))
            ->whereIn('code', $folders)
            ->toArray();
    }

    protected function getModuleData(string $module, string $name = null): Collection
    {
        switch ($module) {
            case 'plugin':
                $plugin = $this->pluginRepository->find($name);
                return new Collection(
                    [
                        'title' => $plugin->getDisplayName(),
                        'key' => namespace_snakename($plugin->get('name')),
                        'namespace' => $plugin->getDomainName(),
                        'type' => 'plugin',
                        'path' => $plugin->getPath('src/resources/lang')
                    ]
                );
            case 'theme':
                return new Collection(
                    [
                        'title' => $plugin->getDisplayName(),
                        'key' => namespace_snakename($plugin->get('name')),
                        'namespace' => '*',
                        'type' => 'theme',
                        'path' => $plugin->getPath('src/resources/lang')
                    ]
                );
        }
    }

    /**
     * Get all language trans
     *
     * @param string $name
     * @param string $module
     * @return array
     */
    protected function getLocalTranslates(string $name, string $module = 'cms')
    {
        $files = File::files($this->originPath($key, $locale));
        $files = collect($files)
            ->filter(fn ($item) => $item->getExtension() == 'php')
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
