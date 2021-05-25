<?php

namespace App\FileManager\Events;

class ImageIsResizing
{
    private $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function path()
    {
        return $this->path;
    }
}
