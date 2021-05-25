<?php

namespace App\Module\Exceptions;

class InvalidActivatorClass extends \Exception
{
    public static function missingConfig()
    {
        return new static("You don't have a valid activator configuration class. This might be due to your config being out of date. \n Run php artisan vendor:publish --provider=\"App\Module\LaravelModulesServiceProvider\" --force to publish the up to date configuration");
    }
}
