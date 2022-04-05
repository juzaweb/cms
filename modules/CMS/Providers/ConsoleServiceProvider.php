<?php

namespace Juzaweb\Providers;

use Illuminate\Support\ServiceProvider;
use Juzaweb\Console\Commands\InstallCommand;
use Juzaweb\Console\Commands\Plugin\ActionMakeCommand;
use Juzaweb\Console\Commands\Plugin\CommandMakeCommand;
use Juzaweb\Console\Commands\Plugin\ControllerMakeCommand;
use Juzaweb\Console\Commands\Plugin\DisableCommand;
use Juzaweb\Console\Commands\Plugin\PublishCommand;
use Juzaweb\Console\Commands\Plugin\EnableCommand;
use Juzaweb\Console\Commands\Plugin\EventMakeCommand;
use Juzaweb\Console\Commands\Plugin\FactoryMakeCommand;
use Juzaweb\Console\Commands\Plugin\InstallCommand as PluginInstallCommand;
use Juzaweb\Console\Commands\Plugin\JobMakeCommand;
use Juzaweb\Console\Commands\Plugin\LaravelModulesV6Migrator;
use Juzaweb\Console\Commands\Plugin\ListCommand;
use Juzaweb\Console\Commands\Plugin\ListenerMakeCommand;
use Juzaweb\Console\Commands\Plugin\MailMakeCommand;
use Juzaweb\Console\Commands\Plugin\MiddlewareMakeCommand;
use Juzaweb\Console\Commands\Plugin\MigrateCommand;
use Juzaweb\Console\Commands\Plugin\MigrateRefreshCommand;
use Juzaweb\Console\Commands\Plugin\MigrateResetCommand;
use Juzaweb\Console\Commands\Plugin\MigrateRollbackCommand;
use Juzaweb\Console\Commands\Plugin\MigrateStatusCommand;
use Juzaweb\Console\Commands\Plugin\MigrationMakeCommand;
use Juzaweb\Console\Commands\Plugin\ModelMakeCommand;
use Juzaweb\Console\Commands\Plugin\ModuleDeleteCommand;
use Juzaweb\Console\Commands\Plugin\ModuleMakeCommand;
use Juzaweb\Console\Commands\Plugin\NotificationMakeCommand;
use Juzaweb\Console\Commands\Plugin\PolicyMakeCommand;
use Juzaweb\Console\Commands\Plugin\ProviderMakeCommand;
use Juzaweb\Console\Commands\Plugin\RequestMakeCommand;
use Juzaweb\Console\Commands\Plugin\ResourceMakeCommand;
use Juzaweb\Console\Commands\Plugin\RouteProviderMakeCommand;
use Juzaweb\Console\Commands\Plugin\RuleMakeCommand;
use Juzaweb\Console\Commands\Plugin\SeedCommand;
use Juzaweb\Console\Commands\Plugin\SeedMakeCommand;
use Juzaweb\Console\Commands\Plugin\SetupCommand;
use Juzaweb\Console\Commands\Plugin\TestMakeCommand;
use Juzaweb\Console\Commands\Plugin\UnUseCommand;
use Juzaweb\Console\Commands\Plugin\UseCommand;
use Juzaweb\Console\Commands\Resource\DatatableMakeCommand;
use Juzaweb\Console\Commands\Resource\JuzawebResouceMakeCommand;
use Juzaweb\Console\Commands\SendMailCommand;
use Juzaweb\Console\Commands\Theme\ThemeGeneratorCommand;
use Juzaweb\Console\Commands\Theme\ThemeListCommand;
use Juzaweb\Console\Commands\Theme\ThemePublishCommand;
use Juzaweb\Console\Commands\UpdateCommand;
use Juzaweb\Console\Commands\MakeAdminCommand;

class ConsoleServiceProvider extends ServiceProvider
{
    /**
     * The available commands
     *
     * @var array
     */
    protected $commands = [
        InstallCommand::class,
        UpdateCommand::class,
        PluginInstallCommand::class,
        CommandMakeCommand::class,
        ControllerMakeCommand::class,
        DisableCommand::class,
        //DumpCommand::class,
        EnableCommand::class,
        EventMakeCommand::class,
        JobMakeCommand::class,
        ListenerMakeCommand::class,
        PublishCommand::class,
        //MailMakeCommand::class,
        MiddlewareMakeCommand::class,
        //NotificationMakeCommand::class,
        ProviderMakeCommand::class,
        RouteProviderMakeCommand::class,
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
        SeedCommand::class,
        SeedMakeCommand::class,
        //SetupCommand::class,
        //UnUseCommand::class,
        //UseCommand::class,
        ResourceMakeCommand::class,
        TestMakeCommand::class,
        LaravelModulesV6Migrator::class,
        SendMailCommand::class,
        ThemeGeneratorCommand::class,
        ThemeListCommand::class,
        ThemePublishCommand::class,
        ActionMakeCommand::class,
        DatatableMakeCommand::class,
        JuzawebResouceMakeCommand::class,
        MakeAdminCommand::class,
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
