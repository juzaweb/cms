<?php

namespace Juzaweb\DevTool\Commands\Plugin;

use Illuminate\Console\Command;
use Juzaweb\CMS\Support\Plugin;
use Juzaweb\CMS\Support\Updater\PluginUpdater;
use Juzaweb\CMS\Traits\ModuleCommandTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class UpdateCommand extends Command
{
    use ModuleCommandTrait;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update dependencies for the specified plugin or for all plugins.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $name = $this->argument('module');

        if ($name) {
            $this->updateModule($name);
            return;
        }

        /** @var Plugin $module */
        foreach ($this->laravel['plugins']->getOrdered() as $module) {
            $this->updateModule($module->getName());
        }
    }

    protected function updateModule($name)
    {
        $this->line('Running for plugin: <info>' . $name . '</info>');

        $this->info('Check file update');

        $updater = app(PluginUpdater::class)->find($name);

        $check = $updater->checkForUpdate();

        $force = $this->option('force');

        if (empty($check) && !$force) {
            $this->error("Plugin [{$name}] no new version available.");
            return;
        }

        $this->info('Fetch Data');
        $updater->fetchDataUpdate();

        $this->info('Download File');
        $updater->downloadUpdateFile();

        $this->info('Unzip File');
        $updater->unzipFile();

        $this->info('Move to folder');
        $updater->updateFileAndFolder();

        $this->info('Update database');
        $updater->finish();

        $this->info('Plugin updated successful.');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments(): array
    {
        return [
            ['module', InputArgument::OPTIONAL, 'The name of plugin will be updated.'],
        ];
    }

    public function getOptions(): array
    {
        return [
            ['force', 'f', InputOption::VALUE_OPTIONAL, 'Force the operation to run update.', false],
        ];
    }
}
