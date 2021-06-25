<?php

namespace Mymo\Theme\Facades;

use Illuminate\Support\Facades\Facade;
use Mymo\Theme\Contracts\ThemeContract;

/**
 * @method static set(string $theme)
 * @method static has(string $theme)
 * @method static getThemePath(string $theme)
 * @method static getThemeInfo(string $theme)
 * @method static get(string $theme)
 * @see \Mymo\Theme\Managers\Theme
 */
class Theme extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ThemeContract::class;
    }
}
