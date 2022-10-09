<?php

namespace Juzaweb\DevTool\Commands\Plugin;

use Illuminate\Console\Command;
use Juzaweb\CMS\Support\Updater\PluginUpdater;
use Symfony\Component\Console\Input\InputArgument;

class InstallCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install plugin by name (vendor/name).';

    /**
     * Execute the console command.
     */
    public function handle(PluginUpdater $updater)
    {
        $name = $this->argument('name');
        $plugin = app('plugins')->find($name);
        if ($plugin) {
            $this->error("Plugin [{$name}] already exist.");
            return;
        }

        $this->info('Check file update');

        $updater = $updater->find($name);

        $check = $updater->checkForUpdate();

        if ($check) {
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

            $this->info('Plugin installation successful.');
        } else {
            $this->error("Plugin [{$name}] does not exist.");
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
            ['name', InputArgument::REQUIRED, 'The name of plugin will be installed.'],
            ['version', InputArgument::OPTIONAL, 'The version of plugin will be installed.'],
        ];
    }
}
