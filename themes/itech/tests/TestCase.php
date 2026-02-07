<?php

namespace Juzaweb\Themes\Itech\Tests;

use Juzaweb\Modules\Core\Providers\CoreServiceProvider;
use Juzaweb\Themes\Itech\Providers\ThemeServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

abstract class TestCase extends OrchestraTestCase
{
    protected function setUp(): void
    {
        $this->setUpAliases();
        parent::setUp();
        $this->createMixManifest();

        \Juzaweb\Modules\Core\Translations\Models\Language::updateOrCreate(
            ['code' => 'en'],
            [
                'name' => 'English',
                'default' => true,
            ]
        );
    }

    protected function setUpAliases()
    {
         // Create class aliases for backward compatibility
        if (!class_exists('Juzaweb\Modules\Admin\Models\User')) {
            class_alias(
                'Juzaweb\Modules\Core\Models\User',
                'Juzaweb\Modules\Admin\Models\User'
            );
        }

        if (!class_exists('Juzaweb\Modules\Admin\Models\Guest')) {
            class_alias(
                'Juzaweb\Modules\Core\Models\Guest',
                'Juzaweb\Modules\Admin\Models\Guest'
            );
        }

        // Load and alias UserFactory
        $factoryPath = __DIR__ . '/../vendor/juzaweb/core/database/factories/UserFactory.php';
        if (file_exists($factoryPath)) {
            require_once $factoryPath;
            if (!class_exists('Juzaweb\\Modules\\Admin\\Database\\Factories\\UserFactory')) {
                class_alias(
                    'Juzaweb\\Modules\\Core\\Database\\Factories\\UserFactory',
                    'Juzaweb\\Modules\\Admin\\Database\\Factories\\UserFactory'
                );
            }
        }
    }

    protected function createMixManifest(): void
    {
        $path = public_path('juzaweb');
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        if (!file_exists($path . '/mix-manifest.json')) {
            file_put_contents($path . '/mix-manifest.json', '{}');
        }

        $path = public_path('themes/itech');
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        if (!file_exists($path . '/mix-manifest.json')) {
            file_put_contents($path . '/mix-manifest.json', '{}');
        }
    }

    protected function getPackageProviders($app)
    {
        return [
            \Juzaweb\Hooks\HooksServiceProvider::class,
            \Juzaweb\QueryCache\QueryCacheServiceProvider::class,
            CoreServiceProvider::class,
            ThemeServiceProvider::class,
            \Juzaweb\Modules\Blog\Providers\BlogServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Theme' => \Juzaweb\Modules\Core\Facades\Theme::class,
            'Field' => \Juzaweb\Modules\Core\Facades\Field::class,
            'Module' => \Juzaweb\Modules\Core\Facades\Module::class,
            'Widget' => \Juzaweb\Modules\Core\Facades\Widget::class,
            'Sidebar' => \Juzaweb\Modules\Core\Facades\Sidebar::class,
            'PageTemplate' => \Juzaweb\Modules\Core\Facades\PageTemplate::class,
            'PageBlock' => \Juzaweb\Modules\Core\Facades\PageBlock::class,
            'Chart' => \Juzaweb\Modules\Core\Facades\Chart::class,
            'Breadcrumb' => \Juzaweb\Modules\Core\Facades\Breadcrumb::class,
            'Menu' => \Juzaweb\Modules\Core\Facades\Menu::class,
            'NavMenu' => \Juzaweb\Modules\Core\Facades\NavMenu::class,
            'Thumbnail' => \Juzaweb\Modules\Core\Facades\Thumbnail::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        // Setup database
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        // Setup User model
        $app['config']->set('auth.providers.users.model', \Juzaweb\Modules\Core\Models\User::class);

        // App key
        $app['config']->set('app.key', 'base64:2fl+Ktvkfl+Fuz4Qp/yWci8eZ2y9Gk4W/q3y9Gk4W/s=');

        $app['config']->set('auth.guards.member', [
            'driver' => 'session',
            'provider' => 'users',
        ]);

        $app['config']->set('translatable.fallback_locale', 'en');
        $app['config']->set('translatable.locales', ['en']);
    }

    protected function defineDatabaseMigrations()
    {
        $this->loadLaravelMigrations();
        $this->loadMigrationsFrom(__DIR__ . '/../vendor/juzaweb/core/database/migrations');
        $this->loadMigrationsFrom(__DIR__ . '/../vendor/juzaweb/blog/database/migrations');
    }
}
