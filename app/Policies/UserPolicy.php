<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny.users');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $users): bool
    {
        return $user->can('view.users', $users);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create.users');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $users): bool
    {
        return $user->can('update.users', $users);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $users): bool
    {
        return $user->can('delete.users', $users);
    }
}
