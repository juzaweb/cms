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
     * @param bool $collection
     * @return array
     */
    public function scan(bool $collection = false): array
    {
        $themeDirectories = File::directories($this->basePath);
        $themes = [];

        foreach ($themeDirectories as $themePath) {
            $theme = $this->createTheme(
                $this->app,
                $themePath
            );

            if (!$name = $theme->getName()) {
                continue;
            }

            $themes[$name] = $collection ? $theme->getInfo() : $theme;
        }

        return $themes;
    }

    public function find(string $name): ?Theme
    {
        foreach ($this->all() as $theme) {
            if ($theme->getLowerName() === strtolower($name)) {
                return $theme;
            }
        }

        return null;
    }

    public function all(bool $collection = false): array
    {
        return $this->scan($collection);
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
