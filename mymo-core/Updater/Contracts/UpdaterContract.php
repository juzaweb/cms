<?php

namespace Mymo\Updater\Contracts;

interface UpdaterContract
{
    /**
     * Get a source type instance.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function source(string $name = '');
}
