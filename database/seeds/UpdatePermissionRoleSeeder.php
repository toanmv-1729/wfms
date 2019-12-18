<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class UpdatePermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = Role::where('is_default', 1)->with('permissions')->get();
        foreach ($roles as $role) {
            if (!$role->permissions->count() && $role->name == config('role.main_roles.product_owner')) {
                $role->permissions()->attach(config('permission.default_role_permission.product_owner'));
            } elseif (!$role->permissions->count() && $role->name == config('role.main_roles.scrum_master')) {
                $role->permissions()->attach(config('permission.default_role_permission.scrum_master'));
            } elseif (!$role->permissions->count() && $role->name == config('role.main_roles.member')) {
                $role->permissions()->attach(config('permission.default_role_permission.member'));
            } else {
                return;
            }
        }
    }
}
