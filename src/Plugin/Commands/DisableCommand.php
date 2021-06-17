<?php

namespace Tadcms\Modules\Commands;

use Illuminate\Console\Command;
use Tadcms\Modules\Plugin;
use Symfony\Component\Console\Input\InputArgument;

class DisableCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:disable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Disable the specified plugin.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /** @var Plugin $module */
        $module = $this->laravel['modules']->findOrFail($this->argument('module'));

        if ($module->isEnabled()) {
            $module->disable();

            $this->info("Plugin [{$module}] disabled successful.");
        } else {
            $this->comment("Plugin [{$module}] has already disabled.");
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
