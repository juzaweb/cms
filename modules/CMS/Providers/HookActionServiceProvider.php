<?php
/**
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://github.com/juzaweb/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Providers;

use Illuminate\Support\Facades\Blade;
use Juzaweb\CMS\Support\ServiceProvider;
use Juzaweb\CMS\Contracts\EventyContract;
use Juzaweb\CMS\Support\Hooks\Events;

class HookActionServiceProvider extends ServiceProvider
{
    public function boot()
    {
        /*
         * Adds a directive in Blade for actions
         */
        Blade::directive(
            'do_action',
            function ($expression) {
                return "<?php app(\Juzaweb\CMS\Contracts\EventyContract::class)->action({$expression}); ?>";
            }
        );

        /*
         * Adds a directive in Blade for filters
         */
        Blade::directive(
            'apply_filters',
            function ($expression) {
                return "<?php echo app(\Juzaweb\CMS\Contracts\EventyContract::class)->filter({$expression}); ?>";
            }
        );
    }

    public function register()
    {
        // Registers the eventy singleton.
        $this->app->singleton(
            EventyContract::class,
            function () {
                return new Events();
            }
        );
    }
}
