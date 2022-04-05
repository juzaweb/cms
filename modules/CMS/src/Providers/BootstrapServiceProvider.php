<?php

namespace Juzaweb\Providers;

use Illuminate\Support\ServiceProvider;
use Juzaweb\Contracts\RepositoryInterface;
use Juzaweb\Support\Installer;
use Juzaweb\Facades\Theme;
use Juzaweb\Facades\ActionRegister;

class BootstrapServiceProvider extends ServiceProvider
{
    /**
     * Booting the package.
     */
    public function boot(): void
    {
        $this->app[RepositoryInterface::class]->boot();
    
        $this->booted(function () {
            ActionRegister::init();
        
            if (Installer::alreadyInstalled()) {
                $currentTheme = jw_current_theme();
                $themePath = Theme::getThemePath($currentTheme);
            
                if (is_dir($themePath)) {
                    Theme::set($currentTheme);
                }
            }
        
            do_action('juzaweb.init');
        });
    }

    /**
     * Register the provider.
     */
    public function register(): void
    {
        $this->app[RepositoryInterface::class]->register();
    }
}
