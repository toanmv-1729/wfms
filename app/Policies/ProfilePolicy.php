<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProfilePolicy
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

    public function getProfile(User $user)
    {
        return ($user->user_type == 'company') || in_array('profile-read', has_permissions($user));
    }

    public function updateProfile(User $user)
    {
        return ($user->user_type == 'company') || in_array('profile-write', has_permissions($user));
    }

    public function updatePassword(User $user)
    {
        return ($user->user_type == 'company') || in_array('profile-write', has_permissions($user));
    }
}
