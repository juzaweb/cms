<?php

namespace Juzaweb\DevTool\Commands\Plugin\Migration;

use Illuminate\Console\Command;
use Juzaweb\CMS\Support\Migrations\Migrator;
use Juzaweb\CMS\Support\Plugin;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MigrateStatusCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:migrate-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Status for all plugin migrations';

    /**
     * @var \Juzaweb\CMS\Contracts\LocalPluginRepositoryContract
     */
    protected $module;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->module = $this->laravel['plugins'];

        $name = $this->argument('module');

        if ($name) {
            $module = $this->module->findOrFail($name);

            return $this->migrateStatus($module);
        }

        foreach ($this->module->getOrdered($this->option('direction')) as $module) {
            $this->line('Running for plugin: <info>' . $module->getName() . '</info>');
            $this->migrateStatus($module);
        }
    }

    /**
     * Run the migration from the specified plugin.
     *
     * @param Plugin $module
     */
    protected function migrateStatus(Plugin $module)
    {
        $path = str_replace(base_path(), '', (new Migrator($module, $this->getLaravel()))->getPath());

        $this->call('migrate:status', [
            '--path' => $path,
            '--database' => $this->option('database'),
        ]);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
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
    protected function getOptions()
    {
        return [
            ['direction', 'd', InputOption::VALUE_OPTIONAL, 'The direction of ordering.', 'asc'],
            ['database', null, InputOption::VALUE_OPTIONAL, 'The database connection to use.'],
        ];
    }
}
