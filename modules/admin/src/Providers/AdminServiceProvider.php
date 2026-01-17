<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://cms.juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\Modules\Admin\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Juzaweb\Modules\Admin\Models\User;
use Juzaweb\Modules\Core\Providers\AdminServiceProvider as BaseAdminServiceProvider;

class AdminServiceProvider extends BaseAdminServiceProvider
{
    public function boot(): void
    {
        parent::boot();

        Model::preventLazyLoading(! $this->app->isProduction());

        Gate::define('viewLogViewer', function (?User $user) {
            return $user && $user->isSuperAdmin();
        });
    }

    public function register(): void
    {
        parent::register();

        $this->registerViews();
    }

    protected function registerViews(): void
    {
        $viewPath = resource_path('views/modules/admin');

        $sourcePath = __DIR__ . '/../resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', 'admin-module-views']);

        $this->loadViewsFrom($sourcePath, 'admin');
    }
}
