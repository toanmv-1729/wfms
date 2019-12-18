<?php

namespace App\Observers;

use App\Models\Role;

class RoleObserver
{
    /**
     * Handle the role "created" event.
     *
     * @param  \App\Models\Role  $role
     * @return void
     */
    public function created(Role $role)
    {
        if ($role->name == config('role.main_roles.product_owner')) {
            $role->permissions()->attach(config('permission.default_role_permission.product_owner'));
        } elseif ($role->name == config('role.main_roles.scrum_master')) {
            $role->permissions()->attach(config('permission.default_role_permission.scrum_master'));
        } elseif ($role->name == config('role.main_roles.member')) {
            $role->permissions()->attach(config('permission.default_role_permission.member'));
        } else {
            return;
        }
    }

    /**
     * Handle the role "updated" event.
     *
     * @param  \App\Role  $role
     * @return void
     */
    public function updated(Role $role)
    {
        //
    }

    /**
     * Handle the role "deleted" event.
     *
     * @param  \App\Role  $role
     * @return void
     */
    public function deleted(Role $role)
    {
        //
    }

    /**
     * Handle the role "restored" event.
     *
     * @param  \App\Role  $role
     * @return void
     */
    public function restored(Role $role)
    {
        //
    }

    /**
     * Handle the role "force deleted" event.
     *
     * @param  \App\Role  $role
     * @return void
     */
    public function forceDeleted(Role $role)
    {
        //
    }
}
