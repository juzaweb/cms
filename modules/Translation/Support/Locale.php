<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Translation\Support;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Collection;
use Juzaweb\CMS\Facades\Plugin;
use Juzaweb\CMS\Facades\ThemeLoader;
use Illuminate\Support\Facades\File;
use Juzaweb\Translation\Contracts\TranslationContract;
use Symfony\Component\Finder\SplFileInfo;

class Locale implements TranslationContract
{
    public function all(): Collection
    {
        $result = [];
        $result['core'] = collect(
            [
                'title' => 'CMS',
                'key' => 'core',
                'type' => 'core',
                'path' => base_path('modules/Backend/resources/lang'),
                'publish_path' => resource_path('lang/vendor/cms'),
            ]
        );

        $result = array_merge($result, $this->getLocalePlugins());
        $result = array_merge($result, $this->getLocaleThemes());

        return collect($result);
    }

    public function getLocalePlugins(): array
    {
        $result = [];
        $plugins = Plugin::all();
        foreach ($plugins as $plugin) {
            $name = $plugin->get('name');
            $snakeName = namespace_snakename($name);

            $result[$snakeName] = collect(
                [
                    'title' => $plugin->getDisplayName(),
                    'key' => $snakeName,
                    'type' => 'plugin',
                    'path' => $plugin->getPath('src/resources/lang'),
                    'publish_path' => resource_path("lang/plugins/{$name}"),
                ]
            );
        }

        return $result;
    }

    public function getLocaleThemes(): array
    {
        $result = [];
        $themes = ThemeLoader::all();
        foreach ($themes as $theme) {
            $name = $theme->get('name');
            $result["theme_{$name}"] = collect(
                [
                    'title' => $theme->get('title'),
                    'key' => "theme_{$name}",
                    'type' => 'theme',
                    'path' => base_path("themes/{$name}/lang"),
                    'publish_path' => resource_path("lang/themes/{$name}"),
                ]
            );
        }

        return $result;
    }

    public function getByKey(string $key): mixed
    {
        return $this->all()->get($key, []);
    }

    /**
     * Get all language publish and origin
     *
     * @param Collection|string $key
     * @return array
     */
    public function allLanguage(Collection|string $key): array
    {
        return array_merge(
            $this->allLanguageOrigin($key),
            $this->allLanguagePublish($key)
        );
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
     * @param Collection|string $key
     * @return array
     */
    public function allLanguageOrigin(Collection|string $key): array
    {
        $key = $this->parseVar($key);
        $folderPath = $this->originPath($key);
        if (!is_dir($folderPath)) {
            return [];
        }

        $folders = $this->getLanguageInFolder($folderPath, $key->get('type') == 'theme');

        return collect(config('locales'))
            ->whereIn('code', $folders)
            ->toArray();
    }

    /**
     * Get all language publish from data plugin/theme/core
     *
     * @param Collection|string $key
     * @return array
     */
    public function allLanguagePublish(Collection|string $key): array
    {
        $folderPath = $this->publishPath($key);
        if (!is_dir($folderPath)) {
            return [];
        }

        $folders = $this->getLanguageInFolder($folderPath, $key->get('type') == 'theme');

        return collect(config('locales'))
            ->whereIn('code', $folders)
            ->toArray();
    }

    public function getLanguageInFolder(string $path, $json = false): array
    {
        $folders = File::directories($path);
        $folders = collect($folders)->map(fn ($item) => basename($item))->values()->toArray();

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

    public function originPath(Collection|string $key, string $path = ''): string
    {
        $key = $this->parseVar($key);
        $basePath = $key->get('path');

        if (empty($path)) {
            return $basePath;
        }

        return $basePath.'/'.$path;
    }

    public function publishPath(Collection|string $key, $path = ''): string
    {
        $key = $this->parseVar($key);
        $basePath = $key->get('publish_path');

        if (empty($path)) {
            return $basePath;
        }

        return $basePath.'/'.$path;
    }

    protected function parseVar(Collection|string $key): string|Collection
    {
        if (is_a($key, Collection::class)) {
            return $key;
        }

        return $this->getByKey($key);
    }

    protected function mapGroupKeys(array $lang, $group, $trans, &$result): void
    {
        foreach ($lang as $key => $item) {
            if (is_array($item)) {
                $this->mapGroupKeys($item, $group.'.'.$key, $trans, $result);
            } else {
                $result[] = [
                    'key' => $group.'.'.$key,
                    'value' => $item,
                    'trans' => $trans[$key] ?? $item,
                ];
            }
        }
    }
}
