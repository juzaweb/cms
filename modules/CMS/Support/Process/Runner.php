<?php

namespace Juzaweb\CMS\Support\Process;

use Juzaweb\CMS\Contracts\RepositoryInterface;
use Juzaweb\CMS\Contracts\RunableInterface;

class Runner implements RunableInterface
{
    /**
     * The plugin instance.
     * @var RepositoryInterface
     */
    protected $module;

    public function __construct(RepositoryInterface $module)
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
