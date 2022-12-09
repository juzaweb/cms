<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\CMS\Support\Translations;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\SplFileInfo;

class TranslationLocale
{
    public function __construct(protected Collection $module)
    {
    }

    /**
     * Get all language publish and origin
     *
     * @return Collection
     */
    public function languages(): Collection
    {
        return $this->allLanguageSupport()->merge(
            $this->allLanguagePublish()
        )->merge($this->allLanguageCustom());
    }

    /**
     * Get all language trans
     *
     * @param Collection|string $key
     * @param string $locale
     * @return array
     * @throws FileNotFoundException
     */
    public function getAllTrans(Collection|string $key, string $locale): array
    {
        $key = $this->parseVar($key);
        $enPath = $this->originPath($key, 'en');
        $result = [];

        if (is_dir($enPath)) {
            $files = File::files($enPath);
            $files = collect($files)
                ->filter(fn (SplFileInfo $item) => $item->getExtension() == 'php')
                ->values()
                ->toArray();

            foreach ($files as $file) {
                $trans = [];
                $lang = require($file->getRealPath());
                $langPublish = $this->publishPath($key, $locale.'/'.$file->getFilename());

                if (file_exists($langPublish)) {
                    $langPublish = require($langPublish);
                    foreach ($langPublish as $langKey => $langVal) {
                        $trans[$langKey] = $langVal;
                    }
                }

                $group = str_replace('.php', '', $file->getFilename());
                $this->mapGroupKeys($lang, $group, $trans, $result);
            }
        }

        if ($key->get('type') == 'theme') {
            $jsonPath = $this->originPath($key);
            $files = collect(File::files($jsonPath))
                ->filter(fn (SplFileInfo $item) => $item->getExtension() == 'json')
                ->values();
            foreach ($files as $file) {
                $trans = [];
                $lang = json_decode(File::get($file->getRealPath()), true);
                $langPublish = $this->publishPath($key, $file->getFilename());

                if (file_exists($langPublish)) {
                    $langPublish = json_decode(File::get($langPublish), true);
                    foreach ($langPublish as $langKey => $langVal) {
                        $trans[$langKey] = $langVal;
                    }
                }

                foreach ($lang as $key => $item) {
                    $result[] = [
                        'key' => $key,
                        'value' => $item,
                        'trans' => $trans[$key] ?? $item,
                    ];
                }
            }
        }

        return $result;
    }

    /**
     * Get all language from data plugin/theme/core
     *
     * @return Collection
     */
    public function allLanguageSupport(): Collection
    {
        $folderPath = $this->module->get('lang_path');
        if (!is_dir($folderPath)) {
            return new Collection([]);
        }

        $folders = $this->getLanguageInFolder($folderPath, $this->module->get('type') == 'theme');

        return collect(config('locales'))->whereIn('code', $folders);
    }

    /**
     * Get all language publish from data plugin/theme/core
     *
     * @return Collection
     */
    public function allLanguagePublish(): Collection
    {
        $folderPath = $this->module->get('publish_path');
        if (!is_dir($folderPath)) {
            return new Collection([]);
        }

        $folders = $this->getLanguageInFolder($folderPath, $this->module->get('type') == 'theme');

        return collect(config('locales'))->whereIn('code', $folders);
    }

    public function allLanguageCustom(): Collection
    {
        $codes = get_config('custom_languages', [])[$this->module->get('key')] ?? [];

        return collect(config('locales'))->whereIn('code', $codes);
    }

    public function getLanguageInFolder(string $path, $json = false): array
    {
        $folders = collect(File::directories($path))->map(fn ($item) => basename($item))->values()->toArray();

        if ($json) {
            $files = collect(File::files($path))
                ->filter(
                    fn (SplFileInfo $item) => $item->getExtension() == 'json'
                )->map(
                    fn (SplFileInfo $item) => $item->getFilenameWithoutExtension()
                )->values()
                ->toArray();

            $folders = array_merge($folders, $files);
        }

        return $folders;
    }
}
