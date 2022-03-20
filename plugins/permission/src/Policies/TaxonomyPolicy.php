<?php

namespace Juzaweb\Permission\Policies;

use Juzaweb\Models\Model;
use Juzaweb\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaxonomyPolicy
{
    use HandlesAuthorization;

    public function index(User $user, $type, $taxonomy)
    {
        if (!$user->can("$type.{$taxonomy}")) {
            return false;
        }

        return true;
    }

    public function edit(User $user, Model $model, $type, $taxonomy)
    {
        if (!$user->can("{$type}.{$taxonomy}.edit")) {
            return false;
        }

        return true;
    }

    public function create(User $user, $type, $taxonomy)
    {
        if (!$user->can("{$type}.{$taxonomy}.create")) {
            return false;
        }

        return true;
    }

    public function delete(User $user, Model $model, $type, $taxonomy)
    {
        if (!$user->can("{$type}.{$taxonomy}.delete")) {
            return false;
        }

        return true;
    }
}
