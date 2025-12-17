<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TicketPolicy
{


    /**
     * Every user must match the tenant.
     */
    protected function sameTenant(User $user, Ticket $ticket): bool{
        return $user->tenant_id === $ticket->tenant_id;
    }

    /**
     * Deny system administrators from viewing ticket information.
     */
    public function viewAny(User $user): bool{
        if ($user->hasRole('system_admin')) {
            return false;
        }
        
        return $user->hasRole('consumer')
            || $user->hasRole('agent')
            || $user->hasRole('support_person')
            || $user->hasRole('manager');
    }

    /**
     * consumers only see their own tickets, staff can see all within tenant.
     */
    public function view(User $user, Ticket $ticket): bool
    {
        if ($user->hasRole('system_admin')){return false;}
        if(! $this->sameTenant($user, $ticket)) {return false;}
        if($user->hasRole('consumer')) { return $ticket->user_id === $user->user_id;}
        
        return $user->hasRole('agent')
            || $user->hasRole('support_person')
            || $user->hasRole('manager'); 
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('consumer');
    }

    /**
     * Only agents, Support Persons and Manages can update a ticket.
     */
    public function update(User $user, Ticket $ticket): bool
    {
        if (! $this->sameTenant($user, $ticket)){ return false; }
        if ($user->hasRole('system_admin')) return false;
        if ($user->hasRole('agent') || $user->hasRole('manager')) { return true; }
       
        return false;
    }

    public function updateStatus(User $user, Ticket $ticket){
        if($user->hasRole('system_admin')) return false;
        if (! $this->sameTenant($user, $ticket)) return false;
        if ($user->hasRole('agent') || $user->hasRole('manager')) { return true; }

        // Only allow assigned support person to update status
        if ($user->hasRole('support_person')) {
            return (int)$ticket->assigned_user_id === (int)$user->user_id;
        }
        return false;
    }

    public function assign(User $user, Ticket $ticket): bool
    {
        if ($user->hasRole('system_admin')) return false;
        if (! $this ->sameTenant($user, $ticket)) return false;

        return $user->hasRole('manager') || $user->hasRole('agent');
    }

    /**
     * Only managers can delete a ticket
     */
    public function delete(User $user, Ticket $ticket): bool
    {
        if ($user->hasRole('system_admin')) return false;
        if ($user->tenant_id !== $ticket->tenant_id) return false;

        return $user->hasRole('manager');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Ticket $ticket): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Ticket $ticket): bool
    {
        return false;
    }
}
