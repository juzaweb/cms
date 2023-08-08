<?php

namespace Juzaweb\DevTool\Commands\Plugin\Publish;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class PublishConfigurationCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:publish-config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish a plugin\'s config files to the application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($module = $this->argument('module')) {
            $this->publishConfiguration($module);

            return;
        }

        foreach ($this->laravel['plugins']->allEnabled() as $module) {
            $this->publishConfiguration($module->getName());
        }
    }

    /**
     * @param string $module
     */
    private function publishConfiguration($module)
    {
        $this->call('vendor:publish', [
            '--provider' => $this->getServiceProviderForModule($module),
            '--force' => $this->option('force'),
            '--tag' => ['config'],
        ]);
    }

    /**
     * @param string $module
     * @return string
     */
    private function getServiceProviderForModule($module)
    {
        $namespace = $this->laravel['config']->get('plugin.namespace');
        $studlyName = Str::studly($module);

        return "$namespace\\$studlyName\\Providers\\{$studlyName}ServiceProvider";
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

    /**
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['--force', '-f', InputOption::VALUE_NONE, 'Force the publishing of config files'],
        ];
    }
}
