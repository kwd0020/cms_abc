<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $actor): bool
    {

        return $actor->hasRole('manager')
            || $actor->hasRole('system_admin')
            || $actor->hasRole('agent')
            || $actor->hasRole('support_person');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $actor, User $model): bool
    {
        if($actor->hasRole('system_admin')) { return true;}

        return $actor->tenant_id === $model->tenant_id
            && (
                $actor->hasRole('manager')
                || $actor->hasRole('agent')
                || $actor->hasRole('support_person')
            );
    }

    /**
     * Only managers and System Admins can Register new user
     */
    public function create(User $actor): bool
    {
        return $actor->hasRole('system_admin') || $actor->hasRole('manager');
    }

    /**
     * Only managers can update a user.
     */
    public function update(User $actor, User $model): bool
    {
        if($actor->hasRole('system_admin')){
            return true;
        }


        return $actor->tenant_id == $model->tenant_id
            && $actor->hasRole('manager');
    }

    public function changeTenant(User $actor): bool
    {
        return $actor->hasRole('system_admin');
    }

    /**
     * Only managers can delete a user.
     */
    public function delete(User $actor, User $model): bool
    {
        return $actor->tenant_id === $model->tenant_id
            && $actor->hasRole('manager')
            && $actor->user_id !== $model->user_id;  //Cant delete self.
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
