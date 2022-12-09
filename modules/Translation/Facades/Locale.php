<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Translation\Facades;

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Collection;
use Juzaweb\Translation\Contracts\TranslationContract;

/**
 * @method static Collection[] all()
 * @method static Collection getByKey(string $key)
 * @method static array allLanguage(Collection|string $var)
 * @method static string publishPath(Collection|string $var, string $locale)
 * @method static array getAllTrans(Collection|string $var, string $locale)
 * @see \Juzaweb\Translation\Support\Locale
 */
class Locale extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return TranslationContract::class;
    }
}
