<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Juzaweb\CMS\Models\Model;
use Juzaweb\CMS\Models\User;

class PostPolicy
{
    use HandlesAuthorization;

    public function index(User $user, $type)
    {
        if (!$user->can("post-type.{$type}")) {
            return false;
        }

        return true;
    }

    public function edit(User $user, Model $model, $type)
    {
        if (!$user->can("post-type.{$type}.edit")) {
            return false;
        }

        return true;
    }

    public function create(User $user, $type)
    {
        if (!$user->can("post-type.{$type}.create")) {
            return false;
        }

        return true;
    }

    public function delete(User $user, Model $model, $type)
    {
        if (!$user->can("post-type.{$type}.delete")) {
            return false;
        }

        return true;
    }
}
