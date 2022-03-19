<?php

namespace Juzaweb\Permission\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Juzaweb\Models\Model;
use Juzaweb\Models\User;

class CommentPolicy
{
    use HandlesAuthorization;

    public function index(User $user, $type)
    {
        if (!$user->can("{$type}.comments")) {
            return false;
        }

        return true;
    }

    public function edit(User $user, Model $model, $type)
    {
        if (!$user->can("{$type}.comments.edit")) {
            return false;
        }

        return true;
    }

    public function create(User $user, $type)
    {
        if (!$user->can("{$type}.comments.create")) {
            return false;
        }

        return true;
    }

    public function delete(User $user, Model $model, $type)
    {
        if (!$user->can("{$type}.comments.delete")) {
            return false;
        }

        return true;
    }
}
