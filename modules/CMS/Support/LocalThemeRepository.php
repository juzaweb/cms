<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\CMS\Support;

use Illuminate\Container\Container;
use Illuminate\Support\Facades\File;
use Juzaweb\CMS\Contracts\LocalThemeRepositoryContract;

class LocalThemeRepository implements LocalThemeRepositoryContract
{
    /**
     * Application instance.
     *
     * @var Container
     */
    protected Container $app;

    /**
     * The plugin path.
     *
     * @var string
     */
    protected string $basePath;

    public function __construct(Container $app, string $path)
    {
        $this->app = $app;
        $this->basePath = $path;
    }

    /**
     * Get all theme information.
     *
     * @return \Illuminate\Support\Collection
     */
    public function scan(): \Illuminate\Support\Collection
    {
        $themeDirectories = File::directories($this->basePath);
        $themes = [];

        foreach ($themeDirectories as $theme) {
            $themeConfig = $this->createTheme(
                $this->app,
                "{$this->basePath}/{$theme}"
            );

            $themes[$themeConfig->get('name')] = $themeConfig;
        }

        return new \Illuminate\Support\Collection($themes);
    }

    public function find(string $theme): ?Theme
    {
        $themePath = "{$this->basePath}/{$theme}";
        if (! is_dir($themePath)) {
            return null;
        }

        return $this->createTheme($this->app, $theme, $themePath);
    }

    public function all(): \Illuminate\Support\Collection
    {
        return $this->scan();
    }

    /**
     * Creates a new Plugin instance
     *
     * @param mixed ...$args
     * @return Theme
     */
    protected function createTheme(...$args): Theme
    {
        return new Theme(...$args);
    }
}
