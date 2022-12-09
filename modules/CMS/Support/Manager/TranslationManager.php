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

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Juzaweb\CMS\Contracts\GoogleTranslate;
use Juzaweb\CMS\Contracts\LocalPluginRepositoryContract;
use Juzaweb\CMS\Contracts\LocalThemeRepositoryContract;
use Juzaweb\CMS\Contracts\TranslationFinder;
use Juzaweb\CMS\Contracts\TranslationManager as TranslationManagerContract;
use Juzaweb\CMS\Models\Translation;
use Juzaweb\CMS\Support\Translations\TranslationImporter;
use Juzaweb\CMS\Support\Translations\TranslationTranslate;

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

    public function translate(
        string $source,
        string $target,
        string $module = 'cms',
        string $name = 'core'
    ): TranslationTranslate {
        $module = $this->find($module, $name);

        return $this->createTranslationTranslate($module)->setSource($source)->setTarget($target);
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

    protected function createTranslationTranslate(Collection $module): TranslationTranslate
    {
        return new TranslationTranslate(
            $module,
            $this->googleTranslate,
            $this
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
