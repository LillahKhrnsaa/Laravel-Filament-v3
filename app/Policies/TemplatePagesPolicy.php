<?php

namespace App\Policies;

use App\Models\TemplatePages;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TemplatePagesPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny.template_pages');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TemplatePages $template_pages): bool
    {
        return $user->can('view.template_pages', $template_pages);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create.template_pages');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TemplatePages $template_pages): bool
    {
        return $user->can('update.template_pages', $template_pages);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TemplatePages $template_pages): bool
    {
        return $user->can('delete.template_pages', $template_pages);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TemplatePages $templatePages): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TemplatePages $templatePages): bool
    {
        return false;
    }
}
