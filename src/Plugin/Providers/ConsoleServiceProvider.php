<?php

namespace Tadcms\Modules\Providers;

use Illuminate\Support\ServiceProvider;
use Tadcms\Modules\Commands\CommandMakeCommand;
use Tadcms\Modules\Commands\ControllerMakeCommand;
use Tadcms\Modules\Commands\DisableCommand;
use Tadcms\Modules\Commands\DumpCommand;
use Tadcms\Modules\Commands\EnableCommand;
use Tadcms\Modules\Commands\EventMakeCommand;
use Tadcms\Modules\Commands\FactoryMakeCommand;
use Tadcms\Modules\Commands\InstallCommand;
use Tadcms\Modules\Commands\JobMakeCommand;
use Tadcms\Modules\Commands\LaravelModulesV6Migrator;
use Tadcms\Modules\Commands\ListCommand;
use Tadcms\Modules\Commands\ListenerMakeCommand;
use Tadcms\Modules\Commands\MailMakeCommand;
use Tadcms\Modules\Commands\MiddlewareMakeCommand;
use Tadcms\Modules\Commands\MigrateCommand;
use Tadcms\Modules\Commands\MigrateRefreshCommand;
use Tadcms\Modules\Commands\MigrateResetCommand;
use Tadcms\Modules\Commands\MigrateRollbackCommand;
use Tadcms\Modules\Commands\MigrateStatusCommand;
use Tadcms\Modules\Commands\MigrationMakeCommand;
use Tadcms\Modules\Commands\ModelMakeCommand;
use Tadcms\Modules\Commands\ModuleDeleteCommand;
use Tadcms\Modules\Commands\ModuleMakeCommand;
use Tadcms\Modules\Commands\NotificationMakeCommand;
use Tadcms\Modules\Commands\PolicyMakeCommand;
use Tadcms\Modules\Commands\ProviderMakeCommand;
use Tadcms\Modules\Commands\PublishCommand;
use Tadcms\Modules\Commands\PublishConfigurationCommand;
use Tadcms\Modules\Commands\PublishMigrationCommand;
use Tadcms\Modules\Commands\PublishTranslationCommand;
use Tadcms\Modules\Commands\RequestMakeCommand;
use Tadcms\Modules\Commands\ResourceMakeCommand;
use Tadcms\Modules\Commands\RouteProviderMakeCommand;
use Tadcms\Modules\Commands\RuleMakeCommand;
use Tadcms\Modules\Commands\SeedCommand;
use Tadcms\Modules\Commands\SeedMakeCommand;
use Tadcms\Modules\Commands\SetupCommand;
use Tadcms\Modules\Commands\TestMakeCommand;
use Tadcms\Modules\Commands\UnUseCommand;
use Tadcms\Modules\Commands\UpdateCommand;
use Tadcms\Modules\Commands\UseCommand;

class ConsoleServiceProvider extends ServiceProvider
{
    /**
     * The available commands
     *
     * @var array
     */
    protected $commands = [
        CommandMakeCommand::class,
        ControllerMakeCommand::class,
        DisableCommand::class,
        //DumpCommand::class,
        EnableCommand::class,
        EventMakeCommand::class,
        JobMakeCommand::class,
        ListenerMakeCommand::class,
        //MailMakeCommand::class,
        MiddlewareMakeCommand::class,
        //NotificationMakeCommand::class,
        ProviderMakeCommand::class,
        RouteProviderMakeCommand::class,
        //InstallCommand::class,
        ListCommand::class,
        ModuleDeleteCommand::class,
        ModuleMakeCommand::class,
        //FactoryMakeCommand::class,
        //PolicyMakeCommand::class,
        RequestMakeCommand::class,
        RuleMakeCommand::class,
        MigrateCommand::class,
        MigrateRefreshCommand::class,
        MigrateResetCommand::class,
        MigrateRollbackCommand::class,
        MigrateStatusCommand::class,
        MigrationMakeCommand::class,
        ModelMakeCommand::class,
        //PublishCommand::class,
        //PublishConfigurationCommand::class,
        //PublishMigrationCommand::class,
        //PublishTranslationCommand::class,
        SeedCommand::class,
        SeedMakeCommand::class,
        //SetupCommand::class,
        //UnUseCommand::class,
        //UpdateCommand::class,
        //UseCommand::class,
        ResourceMakeCommand::class,
        TestMakeCommand::class,
        LaravelModulesV6Migrator::class,
    ];

    /**
     * Register the commands.
     */
    public function register()
    {
        $this->commands($this->commands);
    }

    /**
     * @return array
     */
    public function provides()
    {
        $provides = $this->commands;

        return $provides;
    }
}
