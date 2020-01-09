<?php

use App\Models\Ticket;
use App\Models\Project;
use Illuminate\Database\Seeder;

class TicketsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [];
        $faker = \Faker\Factory::create();
        $projects = Project::all();
        $projectIds = $projects->pluck('id')->toArray();
        for ($i = 0; $i < 50; $i++) {
            foreach ($projects as $project) {
                $userIds = $project->users->pluck('id')->toArray();
                $teamIds = $project->teams->pluck('id')->toArray();
                $versionIds = $project->versions->pluck('id')->toArray();
                array_push($datas, [
                    'project_id' => $project->id,
                    'user_id' => $userIds[array_rand($userIds)],
                    'company_id' => $project->company_id,
                    'team_id' => $teamIds[array_rand($teamIds)],
                    'version_id' => $versionIds[array_rand($versionIds)],
                    'assignee_id' => $userIds[array_rand($userIds)],
                    'title' => $faker->text(150),
                    'description' => $faker->text(1200),
                    'tracker' => rand(1,3),
                    'status' => rand(1,7),
                    'priority' => rand(1,5),
                    'start_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
                    'due_date' => $faker->date($format = 'Y-m-d'),
                    'estimated_time' => rand(1, 40),
                    'spend_time' => 0,
                    'progress' => 0,
                ]);
            }
        }
        Ticket::insert($datas);
    }
}
