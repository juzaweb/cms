<?php

namespace Juzaweb\CMS\Providers;

use Illuminate\Support\ServiceProvider;
use Juzaweb\CMS\Console\Commands\InstallCommand;
use Juzaweb\CMS\Console\Commands\Plugin\ActionMakeCommand;
use Juzaweb\CMS\Console\Commands\Plugin\CommandMakeCommand;
use Juzaweb\CMS\Console\Commands\Plugin\ControllerMakeCommand;
use Juzaweb\CMS\Console\Commands\Plugin\DisableCommand;
use Juzaweb\CMS\Console\Commands\Plugin\PublishCommand;
use Juzaweb\CMS\Console\Commands\Plugin\EnableCommand;
use Juzaweb\CMS\Console\Commands\Plugin\EventMakeCommand;
use Juzaweb\CMS\Console\Commands\Plugin\FactoryMakeCommand;
use Juzaweb\CMS\Console\Commands\Plugin\InstallCommand as PluginInstallCommand;
use Juzaweb\CMS\Console\Commands\Plugin\JobMakeCommand;
use Juzaweb\CMS\Console\Commands\Plugin\LaravelModulesV6Migrator;
use Juzaweb\CMS\Console\Commands\Plugin\ListCommand;
use Juzaweb\CMS\Console\Commands\Plugin\ListenerMakeCommand;
use Juzaweb\CMS\Console\Commands\Plugin\MailMakeCommand;
use Juzaweb\CMS\Console\Commands\Plugin\MiddlewareMakeCommand;
use Juzaweb\CMS\Console\Commands\Plugin\MigrateCommand;
use Juzaweb\CMS\Console\Commands\Plugin\MigrateRefreshCommand;
use Juzaweb\CMS\Console\Commands\Plugin\MigrateResetCommand;
use Juzaweb\CMS\Console\Commands\Plugin\MigrateRollbackCommand;
use Juzaweb\CMS\Console\Commands\Plugin\MigrateStatusCommand;
use Juzaweb\CMS\Console\Commands\Plugin\MigrationMakeCommand;
use Juzaweb\CMS\Console\Commands\Plugin\ModelMakeCommand;
use Juzaweb\CMS\Console\Commands\Plugin\ModuleDeleteCommand;
use Juzaweb\CMS\Console\Commands\Plugin\ModuleMakeCommand;
use Juzaweb\CMS\Console\Commands\Plugin\NotificationMakeCommand;
use Juzaweb\CMS\Console\Commands\Plugin\PolicyMakeCommand;
use Juzaweb\CMS\Console\Commands\Plugin\ProviderMakeCommand;
use Juzaweb\CMS\Console\Commands\Plugin\RequestMakeCommand;
use Juzaweb\CMS\Console\Commands\Plugin\ResourceMakeCommand;
use Juzaweb\CMS\Console\Commands\Plugin\RouteProviderMakeCommand;
use Juzaweb\CMS\Console\Commands\Plugin\RuleMakeCommand;
use Juzaweb\CMS\Console\Commands\Plugin\SeedCommand;
use Juzaweb\CMS\Console\Commands\Plugin\SeedMakeCommand;
use Juzaweb\CMS\Console\Commands\Plugin\SetupCommand;
use Juzaweb\CMS\Console\Commands\Plugin\TestMakeCommand;
use Juzaweb\CMS\Console\Commands\Plugin\UnUseCommand;
use Juzaweb\CMS\Console\Commands\Plugin\UseCommand;
use Juzaweb\CMS\Console\Commands\Resource\DatatableMakeCommand;
use Juzaweb\CMS\Console\Commands\Resource\JuzawebResouceMakeCommand;
use Juzaweb\CMS\Console\Commands\SendMailCommand;
use Juzaweb\CMS\Console\Commands\Theme\ThemeGeneratorCommand;
use Juzaweb\CMS\Console\Commands\Theme\ThemeListCommand;
use Juzaweb\CMS\Console\Commands\Theme\ThemePublishCommand;
use Juzaweb\CMS\Console\Commands\UpdateCommand;
use Juzaweb\CMS\Console\Commands\MakeAdminCommand;

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
