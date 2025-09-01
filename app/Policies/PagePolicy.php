<?php

namespace App\Policies;

use App\Models\Pages;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PagePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny.pages');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Pages $pages): bool
    {
        return $user->can('view.pages', $pages);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create.pages');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Pages $pages): bool
    {
        return $user->can('update.pages', $pages);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Pages $pages): bool
    {
        return $user->can('delete.pages', $pages);
    }
}
