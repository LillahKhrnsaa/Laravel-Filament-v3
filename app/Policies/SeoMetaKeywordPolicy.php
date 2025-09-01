<?php

namespace App\Policies;

use App\Models\SeoMetaKeyword;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SeoMetaKeywordPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny.seo_meta_keywords');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SeoMetaKeyword $seo_meta_keywords): bool
    {
        return $user->can('view.seo_meta_keywords', $seo_meta_keywords);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create.seo_meta_keywords');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SeoMetaKeyword $seo_meta_keywords): bool
    {
        return $user->can('update.seo_meta_keywords', $seo_meta_keywords);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SeoMetaKeyword $seo_meta_keywords): bool
    {
        return $user->can('delete.seo_meta_keywords', $seo_meta_keywords);
    }
}
