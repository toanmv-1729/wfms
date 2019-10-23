<?php

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;

class UpdateRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userIds = User::where('user_type', config('user.type.company'))
            ->get(['id'])
            ->pluck('id')
            ->toArray();
        $ownedHasRoleIds = Role::groupBy('user_id')
            ->get(['user_id'])
            ->pluck('user_id')
            ->toArray();
        $userIdsUpdateRole = array_diff($userIds, $ownedHasRoleIds);
        $datas = [];
        foreach ($userIdsUpdateRole as $userId) {
            foreach (config('role.main_roles') as $value) {
                array_push($datas, [
                    'user_id' => $userId,
                    'name' => $value,
                    'is_default' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        Role::insert($datas);
    }
}
