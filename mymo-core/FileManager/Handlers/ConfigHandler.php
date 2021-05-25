<?php

namespace App\FileManager\Handlers;

class ConfigHandler
{
    public function userField()
    {
        return auth()->id();
    }
}
