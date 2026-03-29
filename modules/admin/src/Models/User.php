<?php

namespace Juzaweb\Modules\Admin\Models;

use Juzaweb\Modules\Core\Models\User as BaseUser;
use Juzaweb\Modules\Core\Traits\HasPassportPasswordGrant;
use Laravel\Passport\HasApiTokens;

class User extends BaseUser
{
    use HasApiTokens, HasPassportPasswordGrant;
}
