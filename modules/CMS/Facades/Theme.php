<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Facades;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade as FacadeAlias;
use Juzaweb\CMS\Support\LocalThemeRepository;
use Juzaweb\CMS\Support\Theme as ThemeSupport;

/**
 * @method static ThemeSupport|null find(string $name)
 * @method static ThemeSupport currentTheme()
 * @method static void activate(string $name)
 * @method static void delete(string $name)
 * @method static Factory|View|string render(string $view, array $params = [], ?string $theme = null)
 * @method static array|Collection all(bool $collection = false)
 * @method static mixed parseParam(mixed $param)
 *
 * @see LocalThemeRepository
 */
class Theme extends FacadeAlias
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'themes';
    }
}
