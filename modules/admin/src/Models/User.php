<?php

namespace Juzaweb\Modules\Admin\Models;

use Juzaweb\Modules\Core\Models\User as BaseUser;
use Laravel\Sanctum\HasApiTokens;

class User extends BaseUser
{
    use HasApiTokens;
}
