<?php

namespace Juzaweb\CMS\Support;

use Juzaweb\CMS\Abstracts\FileRepository;
use Juzaweb\CMS\Abstracts\Plugin;

class LaravelFileRepository extends FileRepository
{
    /**
     * {@inheritdoc}
     */
    protected function createModule(...$args): Plugin
    {
        return new Module(...$args);
    }
}
