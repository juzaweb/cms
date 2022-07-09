<?php

namespace Juzaweb\CMS\Exceptions;

use InvalidArgumentException;

class WildcardPermissionInvalidArgument extends InvalidArgumentException
{
    public static function create()
    {
        return new static('Wildcard permission must be string, permission id or permission instance');
    }
}
