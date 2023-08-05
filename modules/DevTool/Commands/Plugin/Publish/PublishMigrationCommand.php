<?php

namespace Juzaweb\DevTool\Commands\Plugin\Publish;

use Illuminate\Console\Command;
use Juzaweb\CMS\Support\Migrations\Migrator;
use Juzaweb\CMS\Support\Publishing\MigrationPublisher;
use Symfony\Component\Console\Input\InputArgument;

class PublishMigrationCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:publish-migration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Publish a plugin's migrations to the application";

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($name = $this->argument('module')) {
            $module = $this->laravel['plugins']->findOrFail($name);

            $this->publish($module);

            return;
        }

        foreach ($this->laravel['plugins']->allEnabled() as $module) {
            $this->publish($module);
        }
    }

    /**
     * Publish migration for the specified plugin.
     *
     * @param \Juzaweb\CMS\Support\Plugin $module
     */
    public function publish($module)
    {
        with(new MigrationPublisher(new Migrator($module, $this->getLaravel())))
            ->setRepository($this->laravel['plugins'])
            ->setConsole($this)
            ->publish();
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['module', InputArgument::OPTIONAL, 'The name of plugin being used.'],
        ];
    }
}
