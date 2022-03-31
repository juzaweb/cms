<?php

namespace Juzaweb\Console\Commands\Plugin;

use Illuminate\Console\Command;
use Juzaweb\Support\Manager\UpdateManager;
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
    public function handle()
    {
        $pluginName = $this->argument('name');
        if (is_dir(config('juzaweb.plugin.path') . '/' . $pluginName)) {
            $this->error("Plugin [{$pluginName}] already exist.");
            return;
        }

        $updater = new UpdateManager('plugin', $pluginName);
        $this->info('Check file update');
        $check = $updater->updateStep1();

        if ($check) {
            $this->info('Download File');
            $updater->updateStep2();

            $this->info('Unzip File');
            $updater->updateStep3();

            $this->info('Move to folder');
            $updater->updateStep4();

            $this->info('Update database');
            $updater->updateStep5();

            $this->info('Plugin installation successful.');
        } else {
            $this->error("Plugin [{$pluginName}] does not exist.");
        }
    }

    /**
     * Install the specified plugin.
     *
     * @param string $name
     * @param string $version
     */
    protected function install($name, $version = 'dev-master')
    {
        $updater = new UpdateManager('plugin', $name, $version);
        $updater->update();
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of plugin will be installed.'],
            ['version', InputArgument::OPTIONAL, 'The version of plugin will be installed.'],
        ];
    }
}
