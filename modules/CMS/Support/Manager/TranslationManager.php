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
use Juzaweb\CMS\Contracts\GoogleTranslate;
use Juzaweb\CMS\Contracts\LocalPluginRepositoryContract;
use Juzaweb\CMS\Contracts\LocalThemeRepositoryContract;
use Juzaweb\CMS\Contracts\TranslationFinder;
use Juzaweb\CMS\Contracts\TranslationManager as TranslationManagerContract;
use Juzaweb\CMS\Models\Translation;
use Juzaweb\CMS\Support\Translations\TranslationImporter;

class TranslationManager implements TranslationManagerContract
{
    public function __construct(
        protected LocalPluginRepositoryContract $pluginRepository,
        protected LocalThemeRepositoryContract $themeRepository,
        protected TranslationFinder $translationFinder,
        protected GoogleTranslate $googleTranslate
    ) {
    }

    public function export(string $module = 'cms', string $name = null)
    {
        //
    }

    public function import(string $module, string $name = null): TranslationImporter
    {
        $module = $this->find($module, $name);

        return $this->createTranslationImporter($module);
    }

    public function translate(string $source, string $target, string $module = 'cms', string $name = 'core'): array
    {
        $module = $this->find($module, $name);

        $trans = Translation::from('jw_translations AS a')
            ->where('locale', '=', $source)
            ->where('object_type', '=', $module->get('type'))
            ->where('object_key', '=', $module->get('key'))
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
        $errors = [];
        foreach ($trans as $tran) {
            $value = $this->googleTranslate->translate(
                $source,
                $target,
                $tran->value
            );

            if (empty($value)) {
                $errors[] = "Translate {$tran->value} fail";
                continue;
            }

            $newTran = $this->importTranslationLine(
                [
                    'locale' => $target,
                    'group' => $tran->group,
                    'namespace' => $tran->namespace,
                    'key' => $tran->key,
                    'object_type' => $tran->object_type,
                    'object_key' => $tran->object_key,
                    'value' => $value
                ]
            );

            if ($newTran->wasRecentlyCreated) {
                $total += 1;
            }

            sleep(2);
        }

        return ['total' => $total, 'errors' => $errors];
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

    public function importTranslationLine(array $data): Translation
    {
        return Translation::firstOrCreate(
            Arr::only($data, ['locale', 'group', 'namespace', 'key', 'object_type', 'object_key']),
            Arr::only($data, ['value'])
        );
    }

    protected function createTranslationImporter(Collection $module): TranslationImporter
    {
        return new TranslationImporter(
            $module,
            $this->translationFinder,
            $this
        );
    }
}
