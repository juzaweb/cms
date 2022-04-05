<?php

namespace Juzaweb\Permission\Policies;

use Juzaweb\Permission\Abstracts\ResourcePolicy;

class UserPolicy extends ResourcePolicy
{
    protected $resourceType = 'users';
}
