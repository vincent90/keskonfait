<?php

use App\Project;
use App\Task;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $faker = Faker\Factory::create();
        $projects = Project::all();

        foreach ($projects as $project) {

            // add between 2 and 5 tasks to each project
            for ($i = 0; $i < rand(2, 5); $i++) {
                $user = User::findorfail($project->users->random(1)->id);
                $start_at = Carbon::parse($project->start_at)->addDays(rand(1, 25));
                $end_at = Carbon::parse($project->end_at)->subDays(rand(20, 30));

                Auth::login($user);

                $task = Task::create([
                            'name' => $faker->sentence(rand(5, 15)),
                            'description' => $faker->sentence(rand(0, 100)),
                            'start_at' => $start_at->toDateString(),
                            'end_at' => $end_at->toDateString(),
                            'user_id' => $user->id,
                            'status' => 'Open',
                            'project_id' => $project->id,
                ]);

                Auth::logout();

                // add between 0 and 3 subtasks to each task
                for ($i = 0; $i < rand(0, 3); $i++) {
                    $user = User::findorfail($project->users->random(1)->id);
                    $start_at = Carbon::parse($task->start_at)->addDays(rand(1, 2));
                    $end_at = Carbon::parse($task->end_at)->subDays(rand(1, 2));

                    Auth::login($user);

                    $task = $task->children()->create([
                        'name' => $faker->sentence(rand(5, 15)),
                        'description' => $faker->sentence(rand(0, 100)),
                        'start_at' => $start_at->toDateString(),
                        'end_at' => $end_at->toDateString(),
                        'user_id' => $user->id,
                        'status' => 'Open',
                        'project_id' => $project->id,
                    ]);

                    Auth::logout();
                }
            }
        }
    }

}
