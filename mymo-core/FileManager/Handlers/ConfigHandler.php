<?php

namespace Mymo\FileManager\Handlers;

class ConfigHandler
{
    public function userField()
    {
        return auth()->id();
    }
}
