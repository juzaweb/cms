<?php

namespace Juzaweb\DevTool\Commands\Plugin\Publish;

use Illuminate\Console\Command;
use Juzaweb\CMS\Support\Plugin;
use Juzaweb\CMS\Support\Publishing\AssetPublisher;
use Symfony\Component\Console\Input\InputArgument;

class PublishCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish a plugin\'s assets to the application';

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
        if ($name instanceof Plugin) {
            $plugin = $name;
        } else {
            $plugin = $this->laravel['plugins']->findOrFail($name);
        }

        with(new AssetPublisher($plugin))
            ->setRepository($this->laravel['plugins'])
            ->setConsole($this)
            ->publish();

        $this->line("<info>Published</info>: {$plugin->getStudlyName()}");
    }

    /**
     * Publish assets from all plugins.
     */
    public function publishAll()
    {
        foreach ($this->laravel['plugins']->allEnabled() as $plugin) {
            $this->publish($plugin);
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
