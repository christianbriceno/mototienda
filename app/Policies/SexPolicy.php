<?php

namespace App\Policies;

use App\Models\Sex;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SexPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any Sex');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Sex $sex): bool
    {
        return $user->checkPermissionTo('view Sex');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create Sex');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Sex $sex): bool
    {
        return $user->checkPermissionTo('update Sex');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Sex $sex): bool
    {
        return $user->checkPermissionTo('delete Sex');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Sex $sex): bool
    {
        return $user->checkPermissionTo('restore Sex');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Sex $sex): bool
    {
        return $user->checkPermissionTo('forceDelete Sex');
    }
}
