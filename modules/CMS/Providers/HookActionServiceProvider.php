<?php
/**
 * @package    juzaweb/juzaweb
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzawebcms/juzawebcms
 * @license    MIT
 */

namespace Juzaweb\CMS\Providers;

use Illuminate\Support\Facades\Blade;
use Juzaweb\CMS\Facades\Theme;
use Juzaweb\CMS\Support\Installer;
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
        Blade::directive('do_action', function ($expression) {
            return "<?php app(\Juzaweb\CMS\Contracts\EventyContract::class)->action({$expression}); ?>";
        });

        /*
         * Adds a directive in Blade for filters
         */
        Blade::directive('apply_filters', function ($expression) {
            return "<?php echo app(\Juzaweb\CMS\Contracts\EventyContract::class)->filter({$expression}); ?>";
        });

        /*$this->app->booted(function () {
            foreach (static::$actions as $action) {
                app($action)->handle();
            }

            if (Installer::alreadyInstalled()) {
                $currentTheme = jw_current_theme();
                $themePath = Theme::getThemePath($currentTheme);

                if (is_dir($themePath)) {
                    Theme::set($currentTheme);
                }
            }

            do_action('juzaweb.init');
        });*/
    }

    public function register()
    {
        // Registers the eventy singleton.
        $this->app->singleton(EventyContract::class, function () {
            return new Events();
        });
    }
}
