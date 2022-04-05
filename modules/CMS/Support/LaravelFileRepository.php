<?php

namespace Juzaweb\CMS\Support;

use Juzaweb\CMS\Abstracts\FileRepository;

class LaravelFileRepository extends FileRepository
{
    /**
     * {@inheritdoc}
     */
    protected function createModule(...$args)
    {
        return new Module(...$args);
    }
}
