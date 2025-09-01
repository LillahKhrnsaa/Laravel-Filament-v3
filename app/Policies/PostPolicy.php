<?php

namespace App\Policies;

use App\Models\Posts;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny.posts');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Posts $posts): bool
    {
        return $user->can('view.posts', $posts);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create.posts');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Posts $posts): bool
    {
        return $user->can('update.posts', $posts);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Posts $posts): bool
    {
        return $user->can('delete.posts', $posts);
    }
}
