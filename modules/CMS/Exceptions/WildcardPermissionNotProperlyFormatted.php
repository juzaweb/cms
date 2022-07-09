<?php

namespace Juzaweb\CMS\Exceptions;

use InvalidArgumentException;

class WildcardPermissionNotProperlyFormatted extends InvalidArgumentException
{
    public static function create(string $permission)
    {
        return new static("Wildcard permission `{$permission}` is not properly formatted.");
    }
}
