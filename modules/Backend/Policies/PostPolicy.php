<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
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
        if (!$user->can("post-type.{$type}.index")) {
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
