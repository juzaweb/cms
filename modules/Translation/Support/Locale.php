<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Translation\Support;

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
     * Get all language trans
     *
     * @param Collection|string $key
     * @param string $locale
     * @return array
     */
    public function getAllTrans(Collection|string $key, string $locale): array
    {
        $key = $this->parseVar($key);
        $files = File::files($this->originPath($key, 'en'));
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
        $folderPath = $this->originPath($key);
        if (!is_dir($folderPath)) {
            return [];
        }

        $folders = File::directories($folderPath);
        $folders = collect($folders)->map(
            function ($item) {
                return basename($item);
            }
        )->values()->toArray();

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

        $folders = File::directories($folderPath);
        $folders = collect($folders)
            ->map(
                function ($item) {
                    return basename($item);
                }
            )->values()->toArray();

        return collect(config('locales'))
            ->whereIn('code', $folders)
            ->toArray();
    }

    /**
     * Get all language publish and origin
     *
     * @param Collection|string $key
     * @return array
     */
    public function allLanguage(Collection|string $key): array
    {
        return array_merge($this->allLanguageOrigin($key), $this->allLanguagePublish($key));
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

    public function publishPath($key, $path = ''): string
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
