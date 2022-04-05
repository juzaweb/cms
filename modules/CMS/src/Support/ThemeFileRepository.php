<?php
/**
 * Created by PhpStorm.
 * User: dtv
 * Date: 10/12/2021
 * Time: 8:48 PM
 */

namespace Juzaweb\Support;

use Illuminate\Support\Facades\File;

class ThemeFileRepository
{
    /**
     * Application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * The plugin path.
     *
     * @var string|null
     */
    protected $path;

    public function __construct($app, $path)
    {
        $this->app = $app;
        $this->path = $path;
    }

    /**
     * Get all theme information.
     *
     * @return array
     */
    public function all()
    {
        $themeDirectories = File::directories($this->path);
        $themes = [];
        foreach ($themeDirectories as $theme) {
            $themeConfig = new Theme($this->app, basename($theme), $this->path .'/'. $theme);
            if (empty($themeConfig)) {
                continue;
            }

            $themes[$themeConfig->get('name')] = $themeConfig;
        }

        return $themes;
    }

    public function find($theme)
    {
        $themePath = $this->path . '/' . $theme;
        if (! is_dir($themePath)) {
            return false;
        }

        return new Theme($this->app, $theme, $themePath);
    }
}
