<?php

namespace Juzaweb\Backend\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Juzaweb\Backend\Repositories\UserRepository;
use Juzaweb\Backend\Models2\User;
use Juzaweb\Backend\Validators\UserValidator;

/**
 * Class UserRepositoryEloquent.
 *
 * @package namespace Juzaweb\Backend\Repositories;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
