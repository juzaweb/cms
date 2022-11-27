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

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Juzaweb\CMS\Contracts\GoogleTranslate;
use Juzaweb\CMS\Contracts\LocalPluginRepositoryContract;
use Juzaweb\CMS\Contracts\LocalThemeRepositoryContract;
use Juzaweb\CMS\Contracts\TranslationFinder;
use Juzaweb\CMS\Contracts\TranslationManager as TranslationManagerContract;
use Juzaweb\CMS\Models\Translation;

class TranslationManager implements TranslationManagerContract
{
    public function __construct(
        protected LocalPluginRepositoryContract $pluginRepository,
        protected LocalThemeRepositoryContract $themeRepository,
        protected TranslationFinder $translationFinder,
        protected GoogleTranslate $googleTranslate
    ) {
    }

    public function import(string $module, string $name = null): int
    {
        $module = $this->find($module, $name);

        return $this->importLocalTranslations($module, $name)
            + $this->importMissingKeys($module, $name);
    }

    public function importLocalTranslations(string|Collection $module, string $name = null): int
    {
        $locales = $this->getLocalLocales($module, $name);
        $total = 0;
        foreach ($locales as $locale) {
            $result = $this->getLocalTranslates($module, $name, $locale['code']);
            foreach ($result as $item) {
                $model = $this->importTranslationLine(
                    array_merge(
                        $item,
                        [
                            'namespace' => $module->get('namespace'),
                            'locale' => $locale['code'],
                            'object_type' => $module->get('type'),
                            'object_key' => $module->get('key'),
                        ]
                    )
                );

                if ($model->wasRecentlyCreated) {
                    $total += 1;
                }
            }
        }

        return $total;
    }

    public function importMissingKeys(string|Collection $module, string $name = null): int
    {
        $module = $this->find($module, $name);
        $results = $this->translationFinder->find(
            $module->get('src_path')
        );

        $total = 0;
        foreach ($results as $item) {
            $item['object_type'] = $module->get('type');
            $item['object_key'] = $module->get('key');
            $model = $this->importTranslationLine($item);

            if ($model->wasRecentlyCreated) {
                $total += 1;
            }
        }

        return $total;
    }

    public function export(string $module = 'cms', string $name = null)
    {
        //
    }

    public function translate(string $source, string $target, string $module = 'cms', string $name = 'core'): int
    {
        $trans = Translation::from('jw_translations AS a')
            ->where('locale', '=', $source)
            ->where('object_type', '=', $module)
            ->where('object_key', '=', $name)
            ->whereNotExists(
                function (Builder $q) use ($target) {
                    $q->select(['id'])
                        ->from('jw_translations AS b')
                        ->where('locale', '=', $target)
                        ->whereColumn('a.group', '=', 'b.group')
                        ->whereColumn('a.namespace', '=', 'b.namespace')
                        ->whereColumn('a.key', '=', 'b.key')
                        ->whereColumn('a.object_type', '=', 'b.object_type')
                        ->whereColumn('a.object_key', '=', 'b.object_key');
                }
            )
            ->get();

        $total = 0;
        foreach ($trans as $tran) {
            $value = $this->googleTranslate->translate(
                $source,
                $target,
                $tran->value
            );

            if (empty($value)) {
                $this->error("Translate {$tran->value} fail");
                continue;
            }

            $newTran = Translation::firstOrCreate(
                [
                    'locale' => $target,
                    'group' => $tran->group,
                    'namespace' => $tran->namespace,
                    'key' => $tran->key,
                    'object_type' => $tran->object_type,
                    'object_key' => $tran->object_key,
                ],
                [
                    'value' => $value
                ]
            );

            if ($newTran->wasRecentlyCreated) {
                $total += 1;
            }

            sleep(2);
        }

        return $total;
    }

    public function find(string|Collection $module, string $name = null): Collection
    {
        if ($module instanceof Collection) {
            return $module;
        }

        switch ($module) {
            case 'plugin':
                $plugin = $this->pluginRepository->find($name);
                if (empty($plugin)) {
                    throw new \Exception("Plugin {$name} not found");
                }

                return new Collection(
                    [
                        'key' => $plugin->getSnakeName(),
                        'title' => $plugin->getDisplayName(),
                        'name' => $plugin->get('name'),
                        'namespace' => $plugin->getDomainName(),
                        'type' => 'plugin',
                        'lang_path' => $plugin->getPath('src/resources/lang'),
                        'src_path' => $plugin->getPath('src'),
                    ]
                );
            case 'theme':
                $theme = $this->themeRepository->find($name);
                if (empty($theme)) {
                    throw new \Exception("Theme {$name} not found");
                }

                return new Collection(
                    [
                        'key' => 'theme_' . $theme->get('name'),
                        'title' => $theme->get('title'),
                        'name' => $theme->get('name'),
                        'namespace' => '*',
                        'type' => 'theme',
                        'lang_path' => $theme->getPath('lang'),
                        'src_path' => $theme->getPath('views'),
                    ]
                );
            default:
                return new Collection(
                    [
                        'key' => 'core',
                        'title' => 'CMS',
                        'namespace' => 'cms',
                        'type' => 'cms',
                        'lang_path' => base_path('modules/Backend/resources/lang'),
                        'src_path' => base_path('modules'),
                    ]
                );
        }
    }

    protected function getLocalLocales(string|Collection $module = 'cms', string $name = null): array
    {
        $folderPath = $this->find($module, $name)->get('lang_path');
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

    /**
     * Get all language trans
     *
     * @param string|Collection $module
     * @param string|null $name
     * @param string $locale
     * @return array
     * @throws \Exception
     */
    protected function getLocalTranslates(
        string|Collection $module = 'cms',
        string $name = null,
        string $locale = 'en'
    ): array {
        $files = File::files($this->find($module, $name)->get('lang_path') . "/{$locale}");
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
                $prefix = "{$keyPrefix}{$key}.";
                $this->mapGroupKeys($item, $group, $result, $prefix);
            } else {
                $result[] = [
                    'key' => $keyPrefix . $key,
                    'value' => $item,
                    'group' => $group
                ];
            }
        }
    }

    private function importTranslationLine(array $data): Translation
    {
        return Translation::firstOrCreate(
            Arr::only($data, ['locale', 'group', 'namespace', 'key', 'object_type', 'object_key']),
            Arr::only($data, ['value'])
        );
    }
}
