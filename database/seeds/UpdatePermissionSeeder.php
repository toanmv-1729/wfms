<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class UpdatePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Permission::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $permissions = config('permission.action');

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
