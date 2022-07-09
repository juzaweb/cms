<?php

namespace Juzaweb\Backend\Policies;

use Juzaweb\CMS\Models\Model;
use Juzaweb\CMS\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaxonomyPolicy
{
    use HandlesAuthorization;

    public function index(User $user, $type, $taxonomy)
    {
        if (!$user->can("taxonomy.{$type}.{$taxonomy}.index")) {
            return false;
        }

        return true;
    }

    public function edit(User $user, Model $model, $type, $taxonomy)
    {
        if (!$user->can("taxonomy.{$type}.{$taxonomy}.edit")) {
            return false;
        }

        return true;
    }

    public function create(User $user, $type, $taxonomy)
    {
        if (!$user->can("taxonomy.{$type}.{$taxonomy}.store")) {
            return false;
        }

        return true;
    }

    public function delete(User $user, Model $model, $type, $taxonomy)
    {
        if (!$user->can("taxonomy.{$type}.{$taxonomy}.delete")) {
            return false;
        }

        return true;
    }
}
