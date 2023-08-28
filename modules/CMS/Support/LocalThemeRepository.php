<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Support;

use Illuminate\Container\Container;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Inertia\Response;
use Juzaweb\CMS\Contracts\LocalThemeRepositoryContract;
use Juzaweb\CMS\Contracts\Theme\ThemeRender;
use Juzaweb\CMS\Exceptions\ThemeNotFoundException;
use Juzaweb\CMS\Interfaces\Theme\ThemeInterface;

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

    protected Theme $currentTheme;

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

    public function currentTheme(): Theme
    {
        if (isset($this->currentTheme)) {
            return $this->currentTheme;
        }

        return $this->currentTheme = $this->findOrFail(jw_current_theme());
    }

    public function all(bool $collection = false): array|Collection
    {
        return $this->scan($collection);
    }

    public function delete(string $name): bool
    {
        return $this->findOrFail($name)->delete();
    }

    public function render(string $view, array $params = [], ?string $theme = null): Factory|View|string|Response
    {
        $theme = $theme ? $this->findOrFail($theme) : $this->currentTheme();

        return $this->createThemeRender($theme)->render($view, $params);
    }

    public function parseParam(mixed $param, ?string $theme = null): mixed
    {
        $theme = $theme ? $this->findOrFail($theme) : $this->currentTheme();

        return $this->createThemeRender($theme)->parseParam($param);
    }

    public function has(string $name): bool
    {
        return $this->find($name) !== null;
    }

    protected function createThemeRender(ThemeInterface $theme): ThemeRender
    {
        return $this->app->make(ThemeRender::class, ['theme' => $theme]);
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
