<?php
/**
 * Created by PhpStorm.
 * User: dtv
 * Date: 10/12/2021
 * Time: 8:31 PM
 */

namespace Juzaweb\Support;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Noodlehaus\Config;

class Theme
{
    /**
     * The laravel|lumen application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * The plugin name.
     *
     * @var
     */
    protected $name;

    /**
     * The plugin path.
     *
     * @var string
     */
    protected $path;

    /**
     * @var Filesystem
     */
    protected $files;

    public function __construct($app, $name, $path)
    {
        $this->app = $app;
        $this->name = $name;
        $this->path = $path;
        $this->files = $app['files'];
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get path.
     *
     * @param string $path
     * @return string
     */
    public function getPath($path = ''): string
    {
        if (empty($path)) {
            return $this->path;
        }

        return $this->path . '/' . $path;
    }

    /**
     * Get particular theme all information.
     *
     * @return null|Config
     */
    public function getInfo()
    {
        $themeConfigPath = $this->path . '/theme.json';
        $themeChangelogPath = $this->path . '/changelog.yml';

        if (file_exists($themeConfigPath)) {
            $themeConfig = Config::load($themeConfigPath);
            $themeConfig['changelog'] = Config::load($themeChangelogPath)->all();
            $themeConfig['path'] = $this->path;

            return $themeConfig;
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
     * @return string|null
     */
    public function getVersion()
    {
        return $this->get('version', 0);
    }

    /**
     * Get a specific data from json file by given the key.
     *
     * @param string $key
     * @param null $default
     *
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return $this->json()->get($key, $default);
    }

    /**
     * Get json contents from the cache, setting as needed.
     *
     * @param string $file
     *
     * @return Json
     */
    public function json($file = null): Json
    {
        if ($file === null) {
            $file = 'theme.json';
        }

        return new Json($this->getPath() . '/' . $file, $this->files);
    }

    public function activate()
    {
        $this->putCache();

        Artisan::call('theme:publish', [
            'theme' => $this->name,
            'type' => 'assets',
        ]);
    }

    protected function putCache()
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
