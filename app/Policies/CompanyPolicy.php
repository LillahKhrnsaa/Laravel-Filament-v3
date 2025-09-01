<?php

namespace App\Policies;

use App\Models\Companies;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CompanyPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny.companies');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Companies $companies): bool
    {
        return $user->can('view.companies', $companies);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create.companies');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Companies $companies): bool
    {
        return $user->can('update.companies', $companies);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Companies $companies): bool
    {
        return $user->can('delete.companies', $companies);
    }

    public function manageChildren(User $authUser, Companies $company): bool
    {
        return $authUser->can('childern.companies');
    }
}
