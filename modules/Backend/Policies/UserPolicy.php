<?php

namespace Juzaweb\Backend\Policies;

use Juzaweb\CMS\Abstracts\ResourcePolicy;

class UserPolicy extends ResourcePolicy
{
    protected string $resourceType = 'users';
}
