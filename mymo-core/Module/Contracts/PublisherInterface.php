<?php

namespace App\Module\Contracts;

interface PublisherInterface
{
    /**
     * Publish something.
     *
     * @return mixed
     */
    public function publish();
}
