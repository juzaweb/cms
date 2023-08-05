<?php

namespace Juzaweb\DevTool\Commands\Plugin\Migration;

use Illuminate\Console\Command;
use Juzaweb\CMS\Support\Migrations\Migrator;
use Juzaweb\CMS\Support\Plugin;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MigrateCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate the migrations from the specified plugin or from all plugins.';

    /**
     * @var \Juzaweb\CMS\Contracts\LocalPluginRepositoryContract
     */
    protected $module;

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->module = $this->laravel['plugins'];

        $name = $this->argument('module');

        if ($name) {
            $module = $this->module->findOrFail($name);

            $this->migrate($module);

            return;
        }

        foreach ($this->module->getOrdered($this->option('direction')) as $module) {
            $this->line('Running for plugin: <info>' . $module->getName() . '</info>');

            $this->migrate($module);
        }
    }

    /**
     * Run the migration from the specified plugin.
     *
     * @param Plugin $module
     */
    protected function migrate(Plugin $module): void
    {
        $path = str_replace(base_path(), '', (new Migrator($module, $this->getLaravel()))->getPath());

        if ($this->option('subpath')) {
            $path = $path . "/" . $this->option("subpath");
        }

        $this->call(
            'migrate',
            [
                '--path' => $path,
                '--database' => $this->option('database'),
                '--pretend' => $this->option('pretend'),
                '--force' => $this->option('force'),
            ]
        );

        if ($this->option('seed')) {
            $this->call('plugin:seed', ['module' => $module->getName()]);
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments(): array
    {
        return [
            ['module', InputArgument::OPTIONAL, 'The name of plugin will be used.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions(): array
    {
        return [
            ['direction', 'd', InputOption::VALUE_OPTIONAL, 'The direction of ordering.', 'asc'],
            ['database', null, InputOption::VALUE_OPTIONAL, 'The database connection to use.'],
            ['pretend', null, InputOption::VALUE_NONE, 'Dump the SQL queries that would be run.'],
            ['force', null, InputOption::VALUE_NONE, 'Force the operation to run when in production.'],
            ['seed', null, InputOption::VALUE_NONE, 'Indicates if the seed task should be re-run.'],
            ['subpath', null, InputOption::VALUE_OPTIONAL, 'Indicate a subpath to run your migrations from'],
        ];
    }
}
