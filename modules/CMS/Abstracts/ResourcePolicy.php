<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Abstracts;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use Juzaweb\CMS\Models\User;

abstract class ResourcePolicy
{
    use HandlesAuthorization;

    protected string $resourceType;

    public function index(User $user)
    {
        if (!$user->can("{$this->resourceType}.index")) {
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
