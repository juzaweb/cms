<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Support;

use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Juzaweb\CMS\Contracts\LocalThemeRepositoryContract;
use Juzaweb\CMS\Exceptions\ThemeNotFoundException;

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
     * @return array|Collection
     */
    public function scan(bool $collection = false): array|Collection
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

            $themes[$name] = $collection ? $theme->getInfo()->toArray() : $theme;
        }

        return $collection ? (new Collection($themes)) : $themes;
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

    /**
     * Find a specific module, if there return that, otherwise throw exception.
     *
     * @param string $name
     *
     * @return Theme
     *
     * @throws ThemeNotFoundException
     */
    public function findOrFail(string $name): Theme
    {
        $theme = $this->find($name);

        if ($theme !== null) {
            return $theme;
        }

        throw new ThemeNotFoundException("Theme [{$name}] does not exist!");
    }

    public function all(bool $collection = false): array|Collection
    {
        return $this->scan($collection);
    }

    public function delete(string $name): bool
    {
        $theme = $this->findOrFail($name);

        return $theme->delete();
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
