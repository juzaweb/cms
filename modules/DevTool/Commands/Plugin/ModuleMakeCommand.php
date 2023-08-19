<?php

namespace Juzaweb\DevTool\Commands\Plugin;

use Illuminate\Console\Command;
use Juzaweb\CMS\Console\Commands\PluginAutoloadCommand;
use Juzaweb\CMS\Contracts\ActivatorInterface;
use Juzaweb\CMS\Support\Generators\ModuleGenerator;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ModuleMakeCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new plugin.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $names = $this->argument('name');

        foreach ($names as $name) {
            with(new ModuleGenerator($name))
                ->setFilesystem($this->laravel['files'])
                ->setModule($this->laravel['plugins'])
                ->setConfig($this->laravel['config'])
                ->setActivator($this->laravel[ActivatorInterface::class])
                ->setConsole($this)
                ->setForce($this->option('force'))
                ->setPlain($this->option('plain'))
                ->setActive(! $this->option('disabled'))
                ->setTitle($this->option('title'))
                ->setDescription($this->option('description'))
                ->setAuthor($this->option('author'))
                ->setDomain($this->option('domain'))
                ->setVersion($this->option('ver'))
                ->generate();
        }

        $this->call(PluginAutoloadCommand::class);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments(): array
    {
        return [
            ['name', InputArgument::IS_ARRAY, 'The names of plugins will be created.'],
        ];
    }

    protected function getOptions(): array
    {
        return [
            ['plain', 'p', InputOption::VALUE_NONE, 'Generate a plain plugin (without some resources).'],
            ['disabled', 'd', InputOption::VALUE_NONE, 'Do not enable the plugin at creation.'],
            ['force', null, InputOption::VALUE_NONE, 'Force the operation to run when the plugin already exists.'],
            ['title', null, InputOption::VALUE_OPTIONAL, 'The title of the plugin.'],
            ['description', null, InputOption::VALUE_OPTIONAL, 'The description of the plugin.'],
            ['author', null, InputOption::VALUE_OPTIONAL, 'The author of the plugin.'],
            ['domain', null, InputOption::VALUE_OPTIONAL, 'The domain of the plugin.'],
            ['ver', null, InputOption::VALUE_OPTIONAL, 'The version of the plugin.'],
        ];
    }
}
