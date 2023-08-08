<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
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

    /**
     * Check if the user is authorized to view the index page of the resource.
     *
     * @param User $user The user to check authorization for.
     *
     * @return bool True if the user is authorized, false otherwise.
     */
    public function index(User $user)
    {
        if (!$user->can("{$this->resourceType}.index")) {
            return false;
        }

        return true;
    }

    /**
     * Check if the user is authorized to edit the resource.
     *
     * @param User  $user  The user to check authorization for.
     * @param Model $model The model representing the resource.
     *
     * @return bool True if the user is authorized, false otherwise.
     */
    public function edit(User $user, Model $model)
    {
        if (!$user->can("{$this->resourceType}.edit")) {
            return false;
        }

        return true;
    }

    /**
     * Check if the user is authorized to create a new resource.
     *
     * @param User $user The user to check authorization for.
     *
     * @return bool True if the user is authorized, false otherwise.
     */
    public function create(User $user)
    {
        if (!$user->can("{$this->resourceType}.create")) {
            return false;
        }

        return true;
    }

    /**
     * Check if the user is authorized to delete the resource.
     *
     * @param User  $user  The user to check authorization for.
     * @param Model $model The model representing the resource.
     *
     * @return bool True if the user is authorized, false otherwise.
     */
    public function delete(User $user, Model $model)
    {
        if (!$user->can("{$this->resourceType}.delete")) {
            return false;
        }

        return true;
    }
}
