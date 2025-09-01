<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Widgets;
use Illuminate\Auth\Access\Response;

class WidgetsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny.widgets');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Widgets $widgets): bool
    {
        return $user->can('view.widgets', $widgets);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create.widgets');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Widgets $widgets): bool
    {
        return $user->can('update.widgets', $widgets);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Widgets $widgets): bool
    {
        return $user->can('delete.widgets', $widgets);
    }

    
}
