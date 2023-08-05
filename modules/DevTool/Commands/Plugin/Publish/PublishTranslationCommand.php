<?php

namespace Juzaweb\DevTool\Commands\Plugin\Publish;

use Illuminate\Console\Command;
use Juzaweb\CMS\Console\Commands\Plugin\Module;
use Juzaweb\CMS\Support\Publishing\LangPublisher;
use Symfony\Component\Console\Input\InputArgument;

class PublishTranslationCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:publish-translation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish a plugin\'s translations to the application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($name = $this->argument('module')) {
            $this->publish($name);

            return;
        }

        $this->publishAll();
    }

    /**
     * Publish assets from the specified plugin.
     *
     * @param string $name
     */
    public function publish($name)
    {
        if ($name instanceof Module) {
            $module = $name;
        } else {
            $module = $this->laravel['plugins']->findOrFail($name);
        }

        with(new LangPublisher($module))
            ->setRepository($this->laravel['plugins'])
            ->setConsole($this)
            ->publish();

        $this->line("<info>Published</info>: {$module->getStudlyName()}");
    }

    /**
     * Publish assets from all plugins.
     */
    public function publishAll()
    {
        foreach ($this->laravel['plugins']->allEnabled() as $module) {
            $this->publish($module);
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
            ['module', InputArgument::OPTIONAL, 'The name of plugin will be used.'],
        ];
    }
}
