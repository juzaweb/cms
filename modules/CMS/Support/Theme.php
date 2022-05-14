<?php
/**
 * Created by PhpStorm.
 * User: dtv
 * Date: 10/12/2021
 * Time: 8:31 PM
 */

namespace Juzaweb\CMS\Support;

use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Noodlehaus\Config as ReadConfig;

class Theme
{
    /**
     * The laravel|lumen application instance.
     *
     * @var Container
     */
    protected Container $app;

    /**
     * The plugin name.
     *
     * @var string $name
     */
    protected string $name;

    /**
     * The plugin path.
     *
     * @var string
     */
    protected string $path;

    /**
     * @var Filesystem
     */
    protected Filesystem $files;

    public function __construct($app, $path)
    {
        $this->app = $app;
        $this->path = $path;
        $this->files = $app['files'];
    }

    /**
     * Get name.
     *
     * @return ?string
     */
    public function getName(): ?string
    {
        return $this->get('name');
    }

    public function getLowerName(): ?string
    {
        return strtolower($this->getName());
    }

    /**
     * Get path.
     *
     * @param string $path
     * @return string
     */
    public function getPath(string $path = ''): string
    {
        if (empty($path)) {
            return $this->path;
        }

        return "{$this->path}/{$path}";
    }

    /**
     * Get particular theme all information.
     *
     * @return null|Collection
     */
    public function getInfo(): ?Collection
    {
        $themeConfigPath = $this->path . '/theme.json';

        $themeChangelogPath = $this->path . '/changelog.yml';

        if (file_exists($themeConfigPath)) {
            $themeConfig = ReadConfig::load($themeConfigPath)->all();

            $themeConfig['changelog'] = ReadConfig::load($themeChangelogPath)->all();

            $themeConfig['path'] = $this->path;

            return new Collection($themeConfig);
        }

        return null;
    }

    /**
     * Get plugin requirements.
     *
     * @return array
     */
    public function getRequires(): array
    {
        return $this->get('require', []);
    }

    /**
     * Get version theme
     *
     * @return string
     */
    public function getVersion(): string
    {
        return $this->get('version', '0');
    }

    public function asset(string $path, string $default = null): string
    {
        if (str_starts_with($path, 'jw-styles/')) {
            return \asset($path);
        }

        $path = str_replace('assets/', '', $path);

        $path = $this->getPath("assets/public/{$path}");

        if (!file_exists($path)) {
            if (is_url($default)) {
                return $default;
            }

            return \asset($default);
        }

        return \asset("jw-styles/themes/{$this->name}/assets/{$path}");
    }

    public function getScreenshot(): string
    {
        return $this->asset('images/screenshot.svg');
    }

    /**
     * Get a specific data from json file by given the key.
     *
     * @param string $key
     * @param null $default
     *
     * @return mixed
     */
    public function get(string $key, $default = null): mixed
    {
        return $this->json()->get($key, $default);
    }

    /**
     * Get json contents from the cache, setting as needed.
     *
     * @param string|null $file
     *
     * @return Json
     */
    public function json(string $file = null): Json
    {
        if ($file === null) {
            $file = 'theme.json';
        }

        return new Json(
            $this->getPath($file),
            $this->files
        );
    }

    public function activate(): void
    {
        $this->putCache();

        Artisan::call(
            'theme:publish',
            [
                'theme' => $this->name,
                'type' => 'assets',
            ]
        );
    }

    protected function putCache(): void
    {
        Cache::forever('current_theme_info', $this->getInfo());

        $themeStatus = [
            'name' => $this->name,
            'namespace' => 'Theme\\',
            'path' => $this->path .'/'. $this->name,
        ];

        $str = '<?php

return ' . var_export($themeStatus, true) .';

';
        File::put(base_path('bootstrap/cache/theme_statuses.php'), $str);
    }
}
