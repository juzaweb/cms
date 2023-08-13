<?php

namespace Juzaweb\Backend\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;
use Juzaweb\Backend\Actions\BackupAction;
use Juzaweb\Backend\Actions\EmailAction;
use Juzaweb\Backend\Actions\EnqueueStyleAction;
use Juzaweb\Backend\Actions\MediaAction;
use Juzaweb\Backend\Actions\MenuAction;
use Juzaweb\Backend\Actions\PermissionAction;
use Juzaweb\Backend\Actions\SeoAction;
use Juzaweb\Backend\Actions\SocialLoginAction;
use Juzaweb\Backend\Actions\ToolAction;
use Juzaweb\Backend\Commands\AutoSubmitCommand;
use Juzaweb\Backend\Commands\AutoTagCommand;
use Juzaweb\Backend\Commands\EmailTemplateGenerateCommand;
use Juzaweb\Backend\Commands\ImportTranslationCommand;
use Juzaweb\Backend\Commands\OptimizeTagCommand;
use Juzaweb\Backend\Commands\PermissionGenerateCommand;
use Juzaweb\Backend\Commands\PingFeedCommand;
use Juzaweb\Backend\Commands\Post\GeneratePostUUIDCommand;
use Juzaweb\Backend\Commands\Publish\CMSPublishCommand;
use Juzaweb\Backend\Commands\ThemePublishCommand;
use Juzaweb\Backend\Commands\TransFromEnglish;
use Juzaweb\Backend\Models\Comment;
use Juzaweb\Backend\Models\Menu;
use Juzaweb\Backend\Models\Post;
use Juzaweb\Backend\Models\Taxonomy;
use Juzaweb\Backend\Observers\CommentObserver;
use Juzaweb\Backend\Observers\MenuObserver;
use Juzaweb\Backend\Observers\PostObserver;
use Juzaweb\Backend\Observers\TaxonomyObserver;
use Juzaweb\Backend\Repositories\CommentRepository;
use Juzaweb\Backend\Repositories\CommentRepositoryEloquent;
use Juzaweb\Backend\Repositories\Email\EmailTemplateRepository;
use Juzaweb\Backend\Repositories\Email\EmailTemplateRepositoryEloquent;
use Juzaweb\Backend\Repositories\MediaFileRepository;
use Juzaweb\Backend\Repositories\MediaFileRepositoryEloquent;
use Juzaweb\Backend\Repositories\MediaFolderRepository;
use Juzaweb\Backend\Repositories\MediaFolderRepositoryEloquent;
use Juzaweb\Backend\Repositories\MenuRepository;
use Juzaweb\Backend\Repositories\MenuRepositoryEloquent;
use Juzaweb\Backend\Repositories\NotificationRepository;
use Juzaweb\Backend\Repositories\NotificationRepositoryEloquent;
use Juzaweb\Backend\Repositories\PostRepository;
use Juzaweb\Backend\Repositories\PostRepositoryEloquent;
use Juzaweb\Backend\Repositories\ResourceRepository;
use Juzaweb\Backend\Repositories\ResourceRepositoryEloquent;
use Juzaweb\Backend\Repositories\TaxonomyRepository;
use Juzaweb\Backend\Repositories\TaxonomyRepositoryEloquent;
use Juzaweb\Backend\Repositories\UserRepository;
use Juzaweb\Backend\Repositories\UserRepositoryEloquent;
use Juzaweb\CMS\Facades\ActionRegister;
use Juzaweb\CMS\Http\Middleware\Admin;
use Juzaweb\CMS\Facades\Field;
use Juzaweb\CMS\Support\Macros\RouterMacros;
use Juzaweb\CMS\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider
{
    public array $bindings = [
        PostRepository::class => PostRepositoryEloquent::class,
        TaxonomyRepository::class => TaxonomyRepositoryEloquent::class,
        UserRepository::class => UserRepositoryEloquent::class,
        MediaFileRepository::class => MediaFileRepositoryEloquent::class,
        MediaFolderRepository::class => MediaFolderRepositoryEloquent::class,
        NotificationRepository::class => NotificationRepositoryEloquent::class,
        CommentRepository::class => CommentRepositoryEloquent::class,
        MenuRepository::class => MenuRepositoryEloquent::class,
        ResourceRepository::class => ResourceRepositoryEloquent::class,
        EmailTemplateRepository::class => EmailTemplateRepositoryEloquent::class,
    ];

    public function boot(): void
    {
        $this->bootMiddlewares();
        $this->bootPublishes();

        Taxonomy::observe(TaxonomyObserver::class);
        Post::observe(PostObserver::class);
        Menu::observe(MenuObserver::class);
        Comment::observe(CommentObserver::class);

        ActionRegister::register(
            [
                MenuAction::class,
                EnqueueStyleAction::class,
                PermissionAction::class,
                SocialLoginAction::class,
                ToolAction::class,
                SeoAction::class,
                BackupAction::class,
                MediaAction::class,
                EmailAction::class,
            ]
        );

        $this->commands(
            [
                PermissionGenerateCommand::class,
                ImportTranslationCommand::class,
                TransFromEnglish::class,
                EmailTemplateGenerateCommand::class,
                ThemePublishCommand::class,
                AutoSubmitCommand::class,
                AutoTagCommand::class,
                OptimizeTagCommand::class,
                PingFeedCommand::class,
                GeneratePostUUIDCommand::class,
                CMSPublishCommand::class,
            ]
        );
    }

    public function register(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'cms');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'cms');

        $this->app->register(RouteServiceProvider::class);
        $this->app->register(AuthServiceProvider::class);
        $this->registerRouteMacros();
        $this->app->booting(
            function () {
                $loader = AliasLoader::getInstance();
                $loader->alias('Field', Field::class);
            }
        );
    }

    protected function bootMiddlewares(): void
    {
        /**
         * @var Router $router
         */
        $router = $this->app['router'];
        $router->aliasMiddleware('admin', Admin::class);
    }

    protected function bootPublishes(): void
    {
        $this->publishes(
            [
                __DIR__ . '/../resources/views' => resource_path('views/vendor/cms'),
            ],
            'cms_views'
        );

        $this->publishes(
            [
                __DIR__ . '/../resources/lang' => resource_path('lang/cms'),
            ],
            'cms_lang'
        );

        $this->publishes(
            [
                __DIR__ . '/../resources/assets/public' => public_path('jw-styles/juzaweb'),
            ],
            'cms_assets'
        );
    }

    protected function registerRouteMacros(): void
    {
        Router::mixin(new RouterMacros());
    }
}
