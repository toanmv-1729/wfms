<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class UpdateCompanyIdToRolesTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = Role::whereNull('company_id')->with('user')->get();
        foreach ($roles as $role) {
            $role->update([
                'company_id' => optional($role->user)->company_id,
            ]);
        }
    }
}
