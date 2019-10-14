<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        $users = [
            [
                'name' => 'Mai Văn Toàn',
                'email' => 'admin@wfms.com.vn',
                'is_admin' => 1,
                'password' => bcrypt('password'),
                'user_type' => 'admin',
            ],
            [
                'name' => 'Admin 2',
                'email' => 'admin2@wfms.com.vn',
                'is_admin' => 1,
                'password' => bcrypt('password'),
                'user_type' => 'admin',
            ],
            [
                'name' => 'Admin 3',
                'email' => 'admin3@wfms.com.vn',
                'is_admin' => 1,
                'password' => bcrypt('password'),
                'user_type' => 'admin',
            ],
            [
                'name' => 'Admin 4',
                'email' => 'admin4@wfms.com.vn',
                'is_admin' => 1,
                'password' => bcrypt('password'),
                'user_type' => 'admin',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
