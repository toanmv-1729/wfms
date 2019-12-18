<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
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
        return ($user->user_type == 'company') || in_array('role-read', has_permissions($user));
    }

    public function create(User $user)
    {
        return ($user->user_type == 'company') || in_array('role-write', has_permissions($user));
    }

    public function store(User $user)
    {
        return ($user->user_type == 'company') || in_array('role-write', has_permissions($user));
    }

    public function edit(User $user)
    {
        return ($user->user_type == 'company') || in_array('role-write', has_permissions($user));
    }

    public function update(User $user)
    {
        return ($user->user_type == 'company') || in_array('role-write', has_permissions($user));
    }

    public function destroy(User $user)
    {
        return ($user->user_type == 'company') || in_array('role-write', has_permissions($user));
    }
}
