<?php

namespace Juzaweb\Backend\Commands;

use Juzaweb\CMS\Support\Manager\FindTransManager;
use Juzaweb\CMS\Models\Translation;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\SplFileInfo;

class FindTransCommand extends TranslationCommand
{
    protected $signature = 'trans:import';

    /** @var FindTransManager $manager */
    protected $manager;

    public function __construct(FindTransManager $manager)
    {
        $this->manager = $manager;
        parent::__construct();
    }

    public function handle()
    {
        $this->importTranslateFiles();

        $themes = $this->getLocaleThemes();
        foreach ($themes as $theme) {
            $this->manager->findTranslations(
                base_path("themes/{$theme->get('name')}"),
                $theme->get('key'),
                $theme->get('type')
            );

            $this->info("Import successful: {$theme->get('type')}: {$theme->get('key')} - en");
        }

        return Command::SUCCESS;
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

                $this->info("Import successful {$object->get('type')}: {$object->get('key')} - {$locale['code']}");
            }
        }
    }

    /**
     * Get all language trans
     *
     * @param Collection|string $key
     * @param string $locale
     * @return array
     */
    protected function getAllTrans($key, $locale)
    {
        $key = $this->parseVar($key);
        /**
         * @var SplFileInfo[] $files
         */

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
    protected function allLanguageOrigin($key)
    {
        $folderPath = $this->originPath($key);

        if (!is_dir($folderPath)) {
            return [];
        }

        $folders = File::directories($folderPath);
        $folders = collect($folders)
            ->map(
                function ($item) {
                    return basename($item);
                }
            )
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
