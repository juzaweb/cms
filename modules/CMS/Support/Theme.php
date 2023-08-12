<?php

namespace Juzaweb\CMS\Support;

use Illuminate\Container\Container;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Juzaweb\CMS\Interfaces\Theme\ThemeInterface;
use Noodlehaus\Config as ReadConfig;
use Juzaweb\CMS\Facades\Config;

class Theme implements ThemeInterface, Arrayable
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

    protected UrlGenerator $url;

    protected array $register;

    protected array $themeInfo;

    public function __construct($app, $path)
    {
        $this->app = $app;
        $this->path = $path;
        $this->files = $app['files'];
        $this->url = $app['url'];
        $this->name = $this->getName();
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
            return realpath($this->path);
        }

        return realpath($this->path) . "/{$path}";
    }

    public function fileExists(string $path): bool
    {
        return file_exists($this->getPath($path));
    }

    public function getTemplate(): string
    {
        return $this->getInfo()->get('template', 'twig');
    }

    /**
     * @throws FileNotFoundException
     * @throws \Exception
     */
    public function getContents(string $path): ?string
    {
        if (!$this->fileExists($path)) {
            throw new \Exception('File does not exists.');
        }

        return File::get($this->getPath($path));
    }

    public function getViewPublicPath(string $path = null): string
    {
        return resource_path('views/themes/' . $this->name) .'/'. ltrim($path, '/');
    }

    public function getLangPublicPath(string $path = null): string
    {
        return resource_path('lang/themes/' . $this->name) .'/'. ltrim($path, '/');
    }

    /**
     * Get particular theme all information.
     *
     * @param bool $assoc
     * @return array|Collection
     */
    public function getInfo(bool $assoc = false): array|Collection
    {
        if (isset($this->themeInfo)) {
            return $assoc ? $this->themeInfo : new Collection($this->themeInfo);
        }

        $configPath = $this->path . '/theme.json';

        // $changelogPath = $this->path . '/changelog.yml';

        $config = [];

        if (file_exists($configPath)) {
            $config = ReadConfig::load($configPath)->all();
        }

        // $config['changelog'] = ReadConfig::load($changelogPath)->all();

        $config['screenshot'] = $this->getScreenshot();

        $config['path'] = $this->path;

        $this->themeInfo = $config;

        return $assoc ? $this->themeInfo : new Collection($this->themeInfo);
    }

    public function getConfigFields(): array
    {
        return $this->getRegister('configs', []);
    }

    public function getRegister($key = null, $default = null): string|array|null
    {
        $path = $this->getPath('register.json');

        if (!isset($this->register) && File::exists($path)) {
            $this->register = json_decode(File::get($path), true, 512, JSON_THROW_ON_ERROR);
        }

        if ($key) {
            return Arr::get($this->register, $key, $default);
        }

        return $this->register;
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
            return $this->url->asset($path);
        }

        $path = str_replace('assets/', '', $path);

        $fullPath = $this->getPath("assets/public/{$path}");

        if (!file_exists($fullPath)) {
            if (is_url($default)) {
                return $default;
            }

            return $this->url->asset($default);
        }

        return $this->url->asset("jw-styles/themes/{$this->name}/assets/{$path}");
    }

    public function getScreenshot(): string
    {
        return $this->asset(
            'images/screenshot.png',
            'jw-styles/juzaweb/images/screenshot.svg'
        );
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

    public function isActive(): bool
    {
        return jw_current_theme() == $this->name;
    }

    public function activate(): void
    {
        Cache::pull(cache_prefix('jw_theme_configs'));

        $status = [
            'name' => $this->name,
            'namespace' => 'Theme\\',
            'path' => config('juzaweb.theme.path') .'/'.$this->name,
        ];

        Config::setConfig('theme_statuses', $status);

        Artisan::call(
            'theme:publish',
            [
                'theme' => $this->name,
                'type' => 'assets',
            ]
        );
    }

    public function delete(): bool
    {
        if ($this->isActive()) {
            throw new \Exception('Can\'t delete activated theme');
        }

        return $this->json()->getFilesystem()->deleteDirectory($this->getPath());
    }

    public function getPluginRequires(): array
    {
        return $this->json()->get('require', []);
    }

    public function toArray(): array
    {
        return $this->getInfo()->toArray();
    }
}
