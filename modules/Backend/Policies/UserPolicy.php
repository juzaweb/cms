<?php

namespace Juzaweb\Backend\Policies;

use Juzaweb\Backend\Abstracts\ResourcePolicy;

class UserPolicy extends ResourcePolicy
{
    protected $resourceType = 'users';
}
