<?php

namespace App\Policies;

use App\Models\Categories;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny.categories');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Categories $categories): bool
    {
        return $user->can('view.categories', $categories);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create.categories');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Categories $categories): bool
    {
        return $user->can('update.categories', $categories);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Categories $categories): bool
    {
        return $user->can('delete.categories', $categories);
    }
}
