<?php

namespace App\Policies;

use App\Models\Proyecto;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProyectoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
{
    // Solo tú (admin) podrás ver estos módulos
    return $user->role === 'admin';
}

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Proyecto $proyecto): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Proyecto $proyecto): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Proyecto $proyecto): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Proyecto $proyecto): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Proyecto $proyecto): bool
    {
        return false;
    }
}
