<?php

namespace Juzaweb\Modules\Admin\Models;

use Laravel\Passport\HasApiTokens;
use Juzaweb\Modules\Core\Models\User as BaseUser;

class User extends BaseUser
{
    use HasApiTokens;
}
