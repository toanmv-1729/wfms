<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentPolicy
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
        return in_array('document-read', has_permissions($user));
    }

    public function store(User $user)
    {
        return in_array('document-write', has_permissions($user));
    }

    public function update(User $user)
    {
        return in_array('document-write', has_permissions($user));
    }

    public function destroy(User $user)
    {
        return in_array('document-write', has_permissions($user));
    }

    public function indexChild(User $user)
    {
        return in_array('document-read', has_permissions($user));
    }
}
