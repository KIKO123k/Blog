<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $target): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false; // Users cannot create other users via policies
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $target): bool
    {
        return $user->id === $target->id || $user->hasRole(UserRole::ADMIN);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $target): bool
    {
        return $user->hasRole(UserRole::ADMIN) && $user->id !== $target->id;
    }

    /**
     * Determine whether the user can assign roles.
     */
    public function assignRole(User $user): bool
    {
        return $user->hasRole(UserRole::ADMIN);
    }

    /**
     * Only the owner or a verified (admin-approved) recruiter
     * may view/download a student's CV.
     */
    public function viewCv(User $viewer, User $owner): bool
    {
        return $owner->cvVisibleTo($viewer);
    }
}