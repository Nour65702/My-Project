<?php


namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasAnyRole(['Admin', 'Supervisor']);
    }

    public function view(User $user, User $targetUser)
    {
        return $user->hasAnyRole(['Admin', 'Super-admin', 'Supervisor']) || $user->id === $targetUser->id;
    }

    public function create(User $user)
    {
        return $user->hasAnyRole(['Admin', 'Super-admin']);
    }

    public function update(User $user, User $targetUser)
    {
        return $user->hasAnyRole(['Admin', 'Super-admin']) || $user->id === $targetUser->id;
    }

    public function delete(User $user, User $targetUser)
    {
        return $user->hasRole('Super-admin') && $user->id !== $targetUser->id;
    }
}
