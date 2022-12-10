<?php

namespace Juzaweb\DevTool\Providers;

use Illuminate\Support\ServiceProvider;
use Juzaweb\DevTool\Commands\CacheSizeCommand;
use Juzaweb\DevTool\Commands\MakeAdminCommand;
use Juzaweb\DevTool\Commands\Plugin\ActionMakeCommand;
use Juzaweb\DevTool\Commands\Plugin\CommandMakeCommand;
use Juzaweb\DevTool\Commands\Plugin\ControllerMakeCommand;
use Juzaweb\DevTool\Commands\Plugin\DisableCommand;
use Juzaweb\DevTool\Commands\Plugin\EnableCommand;
use Juzaweb\DevTool\Commands\Plugin\EventMakeCommand;
use Juzaweb\DevTool\Commands\Plugin\TranslateViaGoogleCommand;
use Juzaweb\DevTool\Commands\Plugin\ImportTranslationCommand;
use Juzaweb\DevTool\Commands\Plugin\InstallCommand as PluginInstallCommand;
use Juzaweb\DevTool\Commands\Plugin\JobMakeCommand;
use Juzaweb\DevTool\Commands\Plugin\LaravelModulesV6Migrator;
use Juzaweb\DevTool\Commands\Plugin\ListCommand;
use Juzaweb\DevTool\Commands\Plugin\ListenerMakeCommand;
use Juzaweb\DevTool\Commands\Plugin\MiddlewareMakeCommand;
use Juzaweb\DevTool\Commands\Plugin\MigrateCommand;
use Juzaweb\DevTool\Commands\Plugin\MigrateRefreshCommand;
use Juzaweb\DevTool\Commands\Plugin\MigrateResetCommand;
use Juzaweb\DevTool\Commands\Plugin\MigrateRollbackCommand;
use Juzaweb\DevTool\Commands\Plugin\MigrateStatusCommand;
use Juzaweb\DevTool\Commands\Plugin\MigrationMakeCommand;
use Juzaweb\DevTool\Commands\Plugin\ModelMakeCommand;
use Juzaweb\DevTool\Commands\Plugin\ModuleDeleteCommand;
use Juzaweb\DevTool\Commands\Plugin\ModuleMakeCommand;
use Juzaweb\DevTool\Commands\Plugin\ProviderMakeCommand;
use Juzaweb\DevTool\Commands\Plugin\PublishCommand;
use Juzaweb\DevTool\Commands\Plugin\RequestMakeCommand;
use Juzaweb\DevTool\Commands\Plugin\ResourceMakeCommand;
use Juzaweb\DevTool\Commands\Plugin\RouteProviderMakeCommand;
use Juzaweb\DevTool\Commands\Plugin\RuleMakeCommand;
use Juzaweb\DevTool\Commands\Plugin\SeedCommand;
use Juzaweb\DevTool\Commands\Plugin\SeedMakeCommand;
use Juzaweb\DevTool\Commands\Plugin\TestMakeCommand;
use Juzaweb\DevTool\Commands\Plugin\UpdateCommand;
use Juzaweb\DevTool\Commands\Resource\DatatableMakeCommand;
use Juzaweb\DevTool\Commands\Resource\JuzawebResouceMakeCommand;
use Juzaweb\DevTool\Commands\Theme\DownloadStyleCommand;
use Juzaweb\DevTool\Commands\Theme\DownloadTemplateCommand;
use Juzaweb\DevTool\Commands\Theme\GenerateDataThemeCommand;
use Juzaweb\DevTool\Commands\Theme\MakeBlockCommand;
use Juzaweb\DevTool\Commands\Theme\ThemeGeneratorCommand;
use Juzaweb\DevTool\Commands\Theme\ThemeListCommand;
use Juzaweb\DevTool\Commands\Theme\ThemeUpdateCommand;

class ConsoleServiceProvider extends ServiceProvider
{
    protected array $commands = [
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
        ThemeGeneratorCommand::class,
        ThemeListCommand::class,
        ActionMakeCommand::class,
        DatatableMakeCommand::class,
        JuzawebResouceMakeCommand::class,
        MakeAdminCommand::class,
        GenerateDataThemeCommand::class,
        DownloadStyleCommand::class,
        DownloadTemplateCommand::class,
        UpdateCommand::class,
        ThemeUpdateCommand::class,
        MakeBlockCommand::class,
        CacheSizeCommand::class,
        ImportTranslationCommand::class,
        TranslateViaGoogleCommand::class,
        \Juzaweb\DevTool\Commands\Plugin\ExportTranslationCommand::class,
        \Juzaweb\DevTool\Commands\Theme\ExportTranslationCommand::class,
        \Juzaweb\DevTool\Commands\Theme\ImportTranslationCommand::class,
        \Juzaweb\DevTool\Commands\Theme\TranslateViaGoogleCommand::class,
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
        return $this->commands;
    }
}
