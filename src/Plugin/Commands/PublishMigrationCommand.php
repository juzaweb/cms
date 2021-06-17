<?php

namespace Tadcms\Modules\Commands;

use Illuminate\Console\Command;
use Tadcms\Modules\Migrations\Migrator;
use Tadcms\Modules\Publishing\MigrationPublisher;
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
            $module = $this->laravel['modules']->findOrFail($name);

            $this->publish($module);

            return;
        }

        foreach ($this->laravel['modules']->allEnabled() as $module) {
            $this->publish($module);
        }
    }

    /**
     * Publish migration for the specified plugin.
     *
     * @param \Tadcms\Modules\Plugin $module
     */
    public function publish($module)
    {
        with(new MigrationPublisher(new Migrator($module, $this->getLaravel())))
            ->setRepository($this->laravel['modules'])
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
