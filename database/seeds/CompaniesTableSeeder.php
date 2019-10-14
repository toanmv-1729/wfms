<?php

use App\Models\User;
use App\Models\Company;
use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        factory(App\Models\Company::class, 10)->create()->each(function ($item) use ($faker) {
            $data = [
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('wfms'),
                'user_type' => 'company',
                'created_by' => $item->id,
                'company_id' => $item->id,
            ];
            User::create($data);
        });
    }
}
