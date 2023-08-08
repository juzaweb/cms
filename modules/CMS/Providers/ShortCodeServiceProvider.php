<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\CMS\Providers;

use Juzaweb\CMS\Facades\ShortCode;
use Juzaweb\CMS\Support\ServiceProvider;

class ShortCodeServiceProvider extends ServiceProvider
{
    public function register()
    {
        //ShortCode::register('b', BoldShortcode::class);
    }
}
