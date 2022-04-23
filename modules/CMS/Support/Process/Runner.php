<?php

namespace Juzaweb\CMS\Support\Process;

use Juzaweb\CMS\Contracts\PluginRepositoryInterface;
use Juzaweb\CMS\Contracts\RunableInterface;

class Runner implements RunableInterface
{
    /**
     * The plugin instance.
     * @var PluginRepositoryInterface
     */
    protected $module;

    public function __construct(PluginRepositoryInterface $module)
    {
        $this->module = $module;
    }

    /**
     * Run the given command.
     *
     * @param string $command
     */
    public function run($command)
    {
        passthru($command);
    }
}
