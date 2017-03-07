<?php

use App\Project;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class ProjectsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $faker = Faker\Factory::create();
        $users = User::all();

        $min = rand(1, 12);
        $max = $min + rand(0, 14);

        foreach ($users as $user) {
            Auth::login($user);

            // add between 2 and 5 projects to each user
            for ($i = 0; $i < rand(2, 5); $i++) {
                $start_at = (new Carbon())->addDays(rand(0, 30));
                $end_at = $start_at->copy()->addDays(rand(60, 80));

                $project = Project::create([
                            'name' => $faker->sentence(rand(5, 15)),
                            'description' => $faker->sentence(rand(0, 100)),
                            'start_at' => $start_at->toDateString(),
                            'end_at' => $end_at->toDateString(),
                            'user_id' => $user->id,
                ]);

                // add a list of users in the project
                $userIds = App\User::whereBetween('id', array($min, $max))->pluck('id')->toArray();

                // add the project manager if he's not already in the list
                if (!in_array($user->id, $userIds)) {
                    array_push($userIds, $user->id);
                }

                $project->users()->sync($userIds);
            }

            Auth::logout();
        }
    }

}
