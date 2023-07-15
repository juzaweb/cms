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
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Juzaweb\CMS\Contracts\LocalThemeRepositoryContract;
use Juzaweb\CMS\Exceptions\ThemeNotFoundException;
use TwigBridge\Facade\Twig;

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

    public function currentTheme(): Theme
    {
        return $this->findOrFail(jw_current_theme());
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

    public function render(string $view, array $params = [], ?string $theme = null): Factory|View|string
    {
        $theme = $theme ? $this->findOrFail($theme) : $this->currentTheme();

        switch ($theme->getTemplate()) {
            case 'twig':
                $params = $this->parseParamsFronend($params);

                return apply_filters('theme.render_view', Twig::render($view, $params));
            default:
                return apply_filters('theme.render_view', view($view, $params));
        }
    }

    protected function parseParamsFronend(array $params): array
    {
        if ($message = session('message')) {
            $params['message'] = $message;
        }

        if ($status = session('status')) {
            $params['status'] = $status;
        }

        foreach ($params as $key => $item) {
            if (is_a($item, 'Illuminate\Support\ViewErrorBag')) {
                continue;
            }

            if ($item instanceof Arrayable) {
                $item = $item->toArray();
                $params[$key] = $item;
            }

            if (!in_array(
                gettype($item),
                [
                    'boolean',
                    'integer',
                    'string',
                    'array',
                    'double',
                ]
            )
            ) {
                unset($params[$key]);
            }
        }

        return $params;
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
