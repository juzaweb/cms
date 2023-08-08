<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\CMS\Support\Translations;

use Closure;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Juzaweb\CMS\Contracts\TranslationManager;
use Juzaweb\CMS\Contracts\TranslationFinder;

class TranslationImporter
{
    protected Closure $progressCallback;

    public function __construct(
        protected Collection $module,
        protected TranslationFinder $translationFinder,
        protected TranslationManager $translationManager
    ) {
    }

    public function run(): int
    {
        return $this->importLocalTranslations() + $this->importMissingKeys();
    }

    public function importLocalTranslations(): int
    {
        $locales = $this->getLocalLocales();
        $total = 0;
        foreach ($locales as $locale) {
            $result = $this->getLocalTranslates($locale['code']);
            foreach ($result as $item) {
                $model = $this->translationManager->importTranslationLine(
                    array_merge(
                        $item,
                        [
                            'namespace' => $this->module->get('namespace'),
                            'locale' => $locale['code'],
                            'object_type' => $this->module->get('type'),
                            'object_key' => $this->module->get('key'),
                        ]
                    )
                );

                if (isset($this->progressCallback)) {
                    call_user_func($this->progressCallback, $model);
                }

                if ($model->wasRecentlyCreated) {
                    $total += 1;
                }
            }
        }

        return $total;
    }

    public function importMissingKeys(): int
    {
        $results = $this->translationFinder->find(
            $this->module->get('src_path')
        );

        if ($this->module->get('type') != 'cms') {
            $results = collect($results)->filter(fn ($item) => $item['namespace'] != 'cms')->toArray();
        }

        $total = 0;
        foreach ($results as $item) {
            $item['object_type'] = $this->module->get('type');
            $item['object_key'] = $this->module->get('key');
            $model = $this->translationManager->importTranslationLine($item);

            if (isset($this->progressCallback)) {
                call_user_func($this->progressCallback, $model);
            }

            if ($model->wasRecentlyCreated) {
                $total += 1;
            }
        }

        return $total;
    }

    public function progressCallback(Closure $progressCallback): static
    {
        $this->progressCallback = $progressCallback;

        return $this;
    }

    protected function getLocalLocales(): array
    {
        $folderPath = $this->module->get('lang_path');
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
     * @param string $locale
     * @return array
     * @throws \Exception
     */
    protected function getLocalTranslates(string $locale = 'en'): array
    {
        $files = File::files($this->module->get('lang_path') . "/{$locale}");
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

    protected function mapGroupKeys(array $lang, $group, &$result, $keyPrefix = ''): void
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
}
