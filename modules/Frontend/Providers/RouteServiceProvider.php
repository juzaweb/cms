<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Frontend\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as BaseServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends BaseServiceProvider
{
    public function map()
    {
        $this->mapAssetRoutes();
        $this->mapThemeRoutes();
    }

    protected function mapThemeRoutes()
    {
        Route::middleware('theme')
            ->group(__DIR__ . '/../routes/theme.php');
    }

    protected function mapAssetRoutes()
    {
        Route::middleware('assets')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../routes/assets.php');
    }
}