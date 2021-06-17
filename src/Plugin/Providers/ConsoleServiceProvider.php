<?php

namespace Mymo\Plugin\Providers;

use Illuminate\Support\ServiceProvider;
use Mymo\Plugin\Commands\CommandMakeCommand;
use Mymo\Plugin\Commands\ControllerMakeCommand;
use Mymo\Plugin\Commands\DisableCommand;
use Mymo\Plugin\Commands\DumpCommand;
use Mymo\Plugin\Commands\EnableCommand;
use Mymo\Plugin\Commands\EventMakeCommand;
use Mymo\Plugin\Commands\FactoryMakeCommand;
use Mymo\Plugin\Commands\InstallCommand;
use Mymo\Plugin\Commands\JobMakeCommand;
use Mymo\Plugin\Commands\LaravelModulesV6Migrator;
use Mymo\Plugin\Commands\ListCommand;
use Mymo\Plugin\Commands\ListenerMakeCommand;
use Mymo\Plugin\Commands\MailMakeCommand;
use Mymo\Plugin\Commands\MiddlewareMakeCommand;
use Mymo\Plugin\Commands\MigrateCommand;
use Mymo\Plugin\Commands\MigrateRefreshCommand;
use Mymo\Plugin\Commands\MigrateResetCommand;
use Mymo\Plugin\Commands\MigrateRollbackCommand;
use Mymo\Plugin\Commands\MigrateStatusCommand;
use Mymo\Plugin\Commands\MigrationMakeCommand;
use Mymo\Plugin\Commands\ModelMakeCommand;
use Mymo\Plugin\Commands\ModuleDeleteCommand;
use Mymo\Plugin\Commands\ModuleMakeCommand;
use Mymo\Plugin\Commands\NotificationMakeCommand;
use Mymo\Plugin\Commands\PolicyMakeCommand;
use Mymo\Plugin\Commands\ProviderMakeCommand;
use Mymo\Plugin\Commands\PublishCommand;
use Mymo\Plugin\Commands\PublishConfigurationCommand;
use Mymo\Plugin\Commands\PublishMigrationCommand;
use Mymo\Plugin\Commands\PublishTranslationCommand;
use Mymo\Plugin\Commands\RequestMakeCommand;
use Mymo\Plugin\Commands\ResourceMakeCommand;
use Mymo\Plugin\Commands\RouteProviderMakeCommand;
use Mymo\Plugin\Commands\RuleMakeCommand;
use Mymo\Plugin\Commands\SeedCommand;
use Mymo\Plugin\Commands\SeedMakeCommand;
use Mymo\Plugin\Commands\SetupCommand;
use Mymo\Plugin\Commands\TestMakeCommand;
use Mymo\Plugin\Commands\UnUseCommand;
use Mymo\Plugin\Commands\UpdateCommand;
use Mymo\Plugin\Commands\UseCommand;

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
