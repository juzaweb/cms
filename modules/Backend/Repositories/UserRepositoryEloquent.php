<?php

namespace Juzaweb\Backend\Repositories;

use Juzaweb\CMS\Models\User;
use Juzaweb\CMS\Repositories\BaseRepositoryEloquent;

/**
 * Class UserRepositoryEloquent.
 *
 * @property User $model
 */
class UserRepositoryEloquent extends BaseRepositoryEloquent implements UserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return User::class;
    }
}
