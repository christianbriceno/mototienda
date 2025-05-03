<?php

namespace App\Policies;

use App\Models\Presentation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PresentationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any Presentation');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Presentation $presentation): bool
    {
        return $user->checkPermissionTo('view Presentation');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create Presentation');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Presentation $presentation): bool
    {
        return $user->checkPermissionTo('update Presentation');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Presentation $presentation): bool
    {
        return $user->checkPermissionTo('delete Presentation');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Presentation $presentation): bool
    {
        return $user->checkPermissionTo('restore Presentation');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Presentation $presentation): bool
    {
        return $user->checkPermissionTo('force-delete Presentation');
    }
}
