<?php

namespace Juzaweb\DevTool\Commands\Plugin;

use Illuminate\Console\Command;
use Juzaweb\Backend\Events\DumpAutoloadPlugin;
use Juzaweb\CMS\Support\Plugin;
use Symfony\Component\Console\Input\InputArgument;

class EnableCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:enable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enable the specified plugin.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        /** @var Plugin $module */
        $module = $this->laravel['plugins']->findOrFail($this->argument('module'));

        if ($module->isDisabled()) {
            $module->enable();

            $this->info("Plugin [{$module}] enabled successful.");
        } else {
            $this->comment("Plugin [{$module}] has already enabled.");
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['module', InputArgument::REQUIRED, 'Plugin name.'],
        ];
    }
}
