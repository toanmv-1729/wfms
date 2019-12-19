<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index(User $user)
    {
        return in_array('ticket-read', has_permissions($user));
    }

    public function all(User $user)
    {
        return in_array('ticket-read', has_permissions($user));
    }

    public function create(User $user)
    {
        return in_array('ticket-write', has_permissions($user));
    }

    public function createSubTicket(User $user)
    {
        return in_array('ticket-write', has_permissions($user));
    }

    public function store(User $user)
    {
        return in_array('ticket-write', has_permissions($user));
    }

    public function show(User $user)
    {
        return in_array('ticket-read', has_permissions($user));
    }

    public function edit(User $user)
    {
        return in_array('ticket-write', has_permissions($user));
    }

    public function update(User $user)
    {
        return in_array('ticket-write', has_permissions($user));
    }

    public function destroy(User $user)
    {
        return in_array('ticket-write', has_permissions($user));
    }

    public function addRelationTicket(User $user)
    {
        return in_array('ticket-write', has_permissions($user));
    }
}
