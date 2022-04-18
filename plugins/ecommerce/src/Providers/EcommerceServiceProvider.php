<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Ecommerce\Providers;

use Juzaweb\Ecommerce\EcommerceAction;
use Juzaweb\CMS\Support\ServiceProvider;
use Juzaweb\CMS\Facades\ActionRegister;

class EcommerceServiceProvider extends ServiceProvider
{
    public function boot()
    {
        ActionRegister::register(EcommerceAction::class);
    }

    public function register()
    {
        //
    }
}
