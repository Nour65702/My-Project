<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Category $category)
    {

        return true;
    }

    public function create(User $user)
    {

        return $user->hasAnyRole(['Admin', 'Super-admin']);
    }

    public function update(User $user, Category $category)
    {

        return $user->hasAnyRole(['Admin', 'Super-admin']);
    }

    public function delete(User $user, Category $category)
    {

        return $user->hasAnyRole(['Admin', 'Super-admin']);
    }

    public function restore(User $user, Category $category)
    {

        return false;
    }

    public function forceDelete(User $user, Category $category)
    {

        return $user->hasAnyRole(['Super-admin']);
    }
}
