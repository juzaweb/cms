<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Backend\Abstracts;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use Juzaweb\Models\User;

abstract class ResourcePolicy
{
    use HandlesAuthorization;

    protected $resourceType;

    public function index(User $user)
    {
        if (!$user->can($this->resourceType)) {
            return false;
        }

        return true;
    }

    public function edit(User $user, Model $model)
    {
        if (!$user->can("{$this->resourceType}.edit")) {
            return false;
        }

        return true;
    }

    public function create(User $user)
    {
        if (!$user->can("{$this->resourceType}.create")) {
            return false;
        }

        return true;
    }

    public function delete(User $user, Model $model)
    {
        if (!$user->can("{$this->resourceType}.delete")) {
            return false;
        }

        return true;
    }
}
