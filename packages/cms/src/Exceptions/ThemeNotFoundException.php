<?php

namespace Juzaweb\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ThemeNotFoundException extends NotFoundHttpException
{
    public function __construct($themeName)
    {
        parent::__construct("Theme [{$themeName}] not found! Maybe you're missing a theme.json file.");
    }
}
