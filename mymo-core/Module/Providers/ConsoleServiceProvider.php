<?php

namespace App\Module\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use App\Module\Commands\CommandMakeCommand;
use App\Module\Commands\ComponentClassMakeCommand;
use App\Module\Commands\ComponentViewMakeCommand;
use App\Module\Commands\ControllerMakeCommand;
use App\Module\Commands\DisableCommand;
use App\Module\Commands\DumpCommand;
use App\Module\Commands\EnableCommand;
use App\Module\Commands\EventMakeCommand;
use App\Module\Commands\FactoryMakeCommand;
use App\Module\Commands\InstallCommand;
use App\Module\Commands\JobMakeCommand;
use App\Module\Commands\LaravelModulesV6Migrator;
use App\Module\Commands\ListCommand;
use App\Module\Commands\ListenerMakeCommand;
use App\Module\Commands\MailMakeCommand;
use App\Module\Commands\MiddlewareMakeCommand;
use App\Module\Commands\MigrateCommand;
use App\Module\Commands\MigrateRefreshCommand;
use App\Module\Commands\MigrateResetCommand;
use App\Module\Commands\MigrateRollbackCommand;
use App\Module\Commands\MigrateStatusCommand;
use App\Module\Commands\MigrationMakeCommand;
use App\Module\Commands\ModelMakeCommand;
use App\Module\Commands\ModuleDeleteCommand;
use App\Module\Commands\ModuleMakeCommand;
use App\Module\Commands\NotificationMakeCommand;
use App\Module\Commands\PolicyMakeCommand;
use App\Module\Commands\ProviderMakeCommand;
use App\Module\Commands\PublishCommand;
use App\Module\Commands\PublishConfigurationCommand;
use App\Module\Commands\PublishMigrationCommand;
use App\Module\Commands\PublishTranslationCommand;
use App\Module\Commands\RequestMakeCommand;
use App\Module\Commands\ResourceMakeCommand;
use App\Module\Commands\RouteProviderMakeCommand;
use App\Module\Commands\RuleMakeCommand;
use App\Module\Commands\SeedCommand;
use App\Module\Commands\SeedMakeCommand;
use App\Module\Commands\SetupCommand;
use App\Module\Commands\TestMakeCommand;
use App\Module\Commands\UnUseCommand;
use App\Module\Commands\UpdateCommand;
use App\Module\Commands\UseCommand;

class ConsoleServiceProvider extends ServiceProvider
{
    /**
     * Namespace of the console commands
     * @var string
     */
    protected $consoleNamespace = "Nwidart\\Modules\\Commands";

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
        InstallCommand::class,
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
        PublishConfigurationCommand::class,
        PublishMigrationCommand::class,
        PublishTranslationCommand::class,
        SeedCommand::class,
        SeedMakeCommand::class,
        SetupCommand::class,
        UnUseCommand::class,
        UpdateCommand::class,
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
