<?php

namespace Juzaweb\Permission\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Juzaweb\Backend\Models\Post;
use Juzaweb\Backend\Models\Taxonomy;
use Juzaweb\Models\User;
use Juzaweb\Permission\Policies\PostPolicy;
use Juzaweb\Permission\Policies\TaxonomyPolicy;
use Juzaweb\Permission\Policies\UserPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Post::class => PostPolicy::class,
        Taxonomy::class => TaxonomyPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(
            function ($user, $ability) {
                if ($user->isAdmin()) {
                    return true;
                }

                return null;
            }
        );
    }
}
