<?php

namespace Mymo\Module\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Mymo\Module\Commands\CommandMakeCommand;
use Mymo\Module\Commands\ComponentClassMakeCommand;
use Mymo\Module\Commands\ComponentViewMakeCommand;
use Mymo\Module\Commands\ControllerMakeCommand;
use Mymo\Module\Commands\DisableCommand;
use Mymo\Module\Commands\DumpCommand;
use Mymo\Module\Commands\EnableCommand;
use Mymo\Module\Commands\EventMakeCommand;
use Mymo\Module\Commands\FactoryMakeCommand;
use Mymo\Module\Commands\InstallCommand;
use Mymo\Module\Commands\JobMakeCommand;
use Mymo\Module\Commands\LaravelModulesV6Migrator;
use Mymo\Module\Commands\ListCommand;
use Mymo\Module\Commands\ListenerMakeCommand;
use Mymo\Module\Commands\MailMakeCommand;
use Mymo\Module\Commands\MiddlewareMakeCommand;
use Mymo\Module\Commands\MigrateCommand;
use Mymo\Module\Commands\MigrateRefreshCommand;
use Mymo\Module\Commands\MigrateResetCommand;
use Mymo\Module\Commands\MigrateRollbackCommand;
use Mymo\Module\Commands\MigrateStatusCommand;
use Mymo\Module\Commands\MigrationMakeCommand;
use Mymo\Module\Commands\ModelMakeCommand;
use Mymo\Module\Commands\ModuleDeleteCommand;
use Mymo\Module\Commands\ModuleMakeCommand;
use Mymo\Module\Commands\NotificationMakeCommand;
use Mymo\Module\Commands\PolicyMakeCommand;
use Mymo\Module\Commands\ProviderMakeCommand;
use Mymo\Module\Commands\PublishCommand;
use Mymo\Module\Commands\PublishConfigurationCommand;
use Mymo\Module\Commands\PublishMigrationCommand;
use Mymo\Module\Commands\PublishTranslationCommand;
use Mymo\Module\Commands\RequestMakeCommand;
use Mymo\Module\Commands\ResourceMakeCommand;
use Mymo\Module\Commands\RouteProviderMakeCommand;
use Mymo\Module\Commands\RuleMakeCommand;
use Mymo\Module\Commands\SeedCommand;
use Mymo\Module\Commands\SeedMakeCommand;
use Mymo\Module\Commands\SetupCommand;
use Mymo\Module\Commands\TestMakeCommand;
use Mymo\Module\Commands\UnUseCommand;
use Mymo\Module\Commands\UpdateCommand;
use Mymo\Module\Commands\UseCommand;

class ConsoleServiceProvider extends ServiceProvider
{
    /**
     * Namespace of the console commands
     * @var string
     */
    protected $consoleNamespace = "Mymo\\Module\\Commands";

    /**
     * The available commands
     * @var array
     */
    protected $commands = [
        CommandMakeCommand::class,
        ControllerMakeCommand::class,
        DisableCommand::class,
        DumpCommand::class,
        EnableCommand::class,
        EventMakeCommand::class,
        JobMakeCommand::class,
        ListenerMakeCommand::class,
        MailMakeCommand::class,
        MiddlewareMakeCommand::class,
        NotificationMakeCommand::class,
        ProviderMakeCommand::class,
        RouteProviderMakeCommand::class,
        //InstallCommand::class,
        ListCommand::class,
        ModuleDeleteCommand::class,
        ModuleMakeCommand::class,
        FactoryMakeCommand::class,
        PolicyMakeCommand::class,
        RequestMakeCommand::class,
        RuleMakeCommand::class,
        MigrateCommand::class,
        MigrateRefreshCommand::class,
        MigrateResetCommand::class,
        MigrateRollbackCommand::class,
        MigrateStatusCommand::class,
        MigrationMakeCommand::class,
        ModelMakeCommand::class,
        PublishCommand::class,
        //PublishConfigurationCommand::class,
        //PublishMigrationCommand::class,
        PublishTranslationCommand::class,
        SeedCommand::class,
        SeedMakeCommand::class,
        SetupCommand::class,
        UnUseCommand::class,
        //UpdateCommand::class,
        UseCommand::class,
        ResourceMakeCommand::class,
        TestMakeCommand::class,
        LaravelModulesV6Migrator::class,
        ComponentClassMakeCommand::class,
        ComponentViewMakeCommand::class,
    ];

    public function register(): void
    {
        $this->commands($this->resolveCommands());
    }

    private function resolveCommands(): array
    {
        $commands = [];

        foreach (config('modules.commands', $this->commands) as $command) {
            $commands[] = Str::contains($command, $this->consoleNamespace) ?
                $command :
                $this->consoleNamespace . "\\" . $command;
        }

        return $commands;
    }

    public function provides(): array
    {
        return $this->commands;
    }
}
