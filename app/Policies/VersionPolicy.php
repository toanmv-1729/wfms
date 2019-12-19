<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class VersionPolicy
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
        return in_array('version-read', has_permissions($user));
    }

    public function store(User $user)
    {
        return in_array('version-write', has_permissions($user));
    }

    public function update(User $user)
    {
        return in_array('version-write', has_permissions($user));
    }

    public function destroy(User $user)
    {
        return in_array('version-write', has_permissions($user));
    }
}
