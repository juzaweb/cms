<?php

namespace Mymo\Theme\Managers;

use Illuminate\Support\Facades\File;
use Noodlehaus\Config;
use Illuminate\Config\Repository;
use Illuminate\Container\Container;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\View\ViewFinderInterface;
use Mymo\Theme\Contracts\ThemeContract;
use Mymo\Theme\Exceptions\ThemeNotFoundException;

class Theme implements ThemeContract
{
    /**
     * Theme Root Path.
     *
     * @var string
     */
    protected $basePath;

    /**
     * Blade View Finder.
     *
     * @var \Illuminate\View\ViewFinderInterface
     */
    protected $finder;

    /**
     * Application Container.
     *
     * @var \Illuminate\Container\Container
     */
    protected $app;

    /**
     * Translator.
     *
     * @var \Illuminate\Contracts\Translation\Translator
     */
    protected $lang;

    /**
     * Config.
     *
     * @var Repository
     */
    protected $config;

    /**
     * Current Active Theme.
     *
     * @var string
     */
    private $activeTheme = null;

    /**
     * Theme constructor.
     *
     * @param Container           $app
     * @param ViewFinderInterface $finder
     * @param Repository          $config
     * @param Translator          $lang
     */
    public function __construct(
        Container $app,
        ViewFinderInterface $finder,
        Repository $config,
        Translator $lang
    ) {
        $this->config = $config;
        $this->app = $app;
        $this->finder = $finder;
        $this->lang = $lang;
        $this->basePath = $this->config['mymo.theme.path'];
    }

    /**
     * Set current theme.
     *
     * @param string $theme
     *
     * @return void
     */
    public function set($theme)
    {
        if (!$this->has($theme)) {
            throw new ThemeNotFoundException($theme);
        }

        $this->loadTheme($theme);
        $this->activeTheme = $theme;
    }

    /**
     * Check if theme exists.
     *
     * @param string $theme
     *
     * @return bool
     */
    public function has($theme)
    {
        $themeConfigPath = $this->getThemePath($theme) . '/theme.json';
        return file_exists($themeConfigPath);
    }

    public function getThemePath($theme)
    {
        return $this->basePath . '/' . $theme;
    }

    /**
     * Get particular theme all information.
     *
     * @param string $theme
     *
     * @return null
     */
    public function getThemeInfo($theme)
    {
        $themePath = $this->getThemePath($theme);
        $themeConfigPath = $themePath . '/theme.json';
        $themeChangelogPath = $themePath . '/changelog.yml';

        if (file_exists($themeConfigPath)) {
            $themeConfig = Config::load($themeConfigPath);
            $themeConfig['changelog'] = Config::load($themeChangelogPath)->all();
            $themeConfig['path'] = $themePath;

            if ($themeConfig->has('name')) {
                return $themeConfig;
            }
        }

        return null;
    }

    /**
     * Returns current theme or particular theme information.
     *
     * @param string $theme
     * @param bool   $collection
     *
     * @return array|null
     */
    public function get($theme = null, $collection = false)
    {
        if (is_null($theme) || !$this->has($theme)) {
            if ($collection) {
                return $this->getThemeInfo($this->activeTheme);
            }

            return $this->getThemeInfo($this->activeTheme)->all();
        }

        if ($collection) {
            return $this->getThemeInfo($theme);
        }

        return $this->getThemeInfo($theme)->all();
    }

    /**
     * Get current active theme name only or themeinfo collection.
     *
     * @param bool $collection
     *
     * @return null
     */
    public function current($collection = false)
    {
        return !$collection ? $this->activeTheme : $this->getThemeInfo($this->activeTheme);
    }

    /**
     * Get all theme information.
     *
     * @return array
     */
    public function all()
    {
        $themeDirectories = File::directories($this->basePath);
        $themes = [];
        foreach ($themeDirectories as $theme) {
            $themeConfig = $this->getThemeInfo(basename($theme));
            if (empty($themeConfig)) {
                continue;
            }

            $themes[$themeConfig->get('name')] = $themeConfig;
        }

        return $themes;
    }

    /**
     * Find asset file for theme asset.
     *
     * @param string    $path
     * @param null|bool $secure
     *
     * @return string
     */
    public function assets($path, $secure = null)
    {
        $fullPath = $this->getFullPath($path);

        return $this->app['url']->asset($fullPath, $secure);
    }

    /**
     * Find theme asset from theme directory.
     *
     * @param string $path
     *
     * @return string|false
     */
    public function getFullPath($path)
    {
        $splitThemeAndPath = explode(':', $path);

        if (count($splitThemeAndPath) > 1) {
            if (is_null($splitThemeAndPath[0])) {
                return false;
            }
            $themeName = $splitThemeAndPath[0];
            $path = $splitThemeAndPath[1];
        } else {
            $themeName = $this->activeTheme;
            $path = $splitThemeAndPath[0];
        }

        $themeInfo = $this->getThemeInfo($themeName);
        $themePath = str_replace(base_path('public').DIRECTORY_SEPARATOR, '', $themeInfo->get('path')).DIRECTORY_SEPARATOR;

        $assetPath = $this->config['theme.folders.assets'].DIRECTORY_SEPARATOR;
        $fullPath = $themePath . $assetPath . $path;

        if (!file_exists($fullPath) && $themeInfo->has('parent') && !empty($themeInfo->get('parent'))) {
            $themePath = str_replace(base_path().DIRECTORY_SEPARATOR, '', $this->getThemeInfo($themeInfo->get('parent'))->get('path')).DIRECTORY_SEPARATOR;
            $fullPath = $themePath.$assetPath.$path;
            return $fullPath;
        }

        return $fullPath;
    }

    /**
     * Get the current theme path to a versioned Mix file.
     *
     * @param string $path
     * @param string $manifestDirectory
     *
     * @return \Illuminate\Support\HtmlString|string
     * @throws \Exception
     */
    public function themeMix($path, $manifestDirectory = '')
    {
        return mix($this->getFullPath($path), $manifestDirectory);
    }

    /**
     * Map view map for particular theme.
     *
     * @param string $theme
     *
     * @return void
     */
    protected function loadTheme($theme)
    {
        if (is_null($theme)) {
            return;
        }

        $themeInfo = $this->getThemeInfo($theme);
        if (is_null($themeInfo)) {
            return;
        }

        $this->loadTheme($themeInfo->get('parent'));
        $viewPath = $themeInfo->get('path') . '/views';
        $langPath = $themeInfo->get('path') .'/lang';

        $this->lang->addNamespace('theme', $langPath);
        $this->finder->prependLocation($viewPath);
        $this->finder->prependNamespace('theme', $viewPath);
    }
}
