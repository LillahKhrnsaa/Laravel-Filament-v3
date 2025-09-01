<?php

namespace App\Policies;

use App\Models\TypeWidgets;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TypeWidgetsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny.type_widgets');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TypeWidgets $type_widgets): bool
    {
        return $user->can('view.type_widgets', $type_widgets);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create.type_widgets');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TypeWidgets $type_widgets): bool
    {
        return $user->can('update.type_widgets', $type_widgets);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TypeWidgets $type_widgets): bool
    {
        return $user->can('delete.type_widgets', $type_widgets);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TypeWidgets $typeWidgets): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TypeWidgets $typeWidgets): bool
    {
        return false;
    }
}
