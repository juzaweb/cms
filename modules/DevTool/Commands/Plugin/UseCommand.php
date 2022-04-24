<?php

namespace Juzaweb\DevTool\Commands\Plugin;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class UseCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:use';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Use the specified plugin.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $module = Str::studly($this->argument('module'));

        if (! $this->laravel['plugins']->has($module)) {
            $this->error("Plugin [{$module}] does not exists.");

            return;
        }

        $this->laravel['plugins']->setUsed($module);

        $this->info("Plugin [{$module}] used successfully.");
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['module', InputArgument::REQUIRED, 'The name of plugin will be used.'],
        ];
    }
}
