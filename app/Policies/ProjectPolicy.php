<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
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
        return ($user->user_type == 'company');
    }

    public function create(User $user)
    {
        return ($user->user_type == 'company');
    }

    public function store(User $user)
    {
        return ($user->user_type == 'company');
    }

    public function edit(User $user)
    {
        return ($user->user_type == 'company') || in_array('project-write', has_permissions($user));
    }

    public function update(User $user)
    {
        return ($user->user_type == 'company') || in_array('project-write', has_permissions($user));
    }
}
