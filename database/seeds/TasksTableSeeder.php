<?php

use App\Task;
use Carbon\Carbon;
use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Seeder;
use Illuminate\Events\Dispatcher;

class TasksTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        // Create the DB manager used by Etrepat/Baum (do not remove or the tasks will behave weirdly when using the application with seeded data).
        $manager = new Manager();
        $manager->addConnection([
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'homestead',
            'username' => 'homestead',
            'password' => 'secret',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]);
        $manager->setEventDispatcher(new Dispatcher(new Container));
        $manager->setAsGlobal();
        $manager->bootEloquent();

        $faker = Faker\Factory::create();

        // Add a list of root tasks for every project.
        $projects = App\Project::all();

        foreach ($projects as $project) {
            for ($i = 0; $i < rand(2, 10); $i++) {
                $start_at = Carbon::parse($project->start_at)->addDays(rand(2, 10));
                $end_at = Carbon::parse($project->end_at)->subDays(rand(2, 10));

                $task = Task::create([
                            'name' => $faker->sentence(rand(5, 15)),
                            'description' => $faker->sentence(rand(0, 100)),
                            'start_at' => $start_at->toDateString(),
                            'end_at' => $end_at->toDateString(),
                            'user_id' => $project->users->random(1)->id,
                            'status' => 'Open',
                            'project_id' => $project->id,
                ]);
                $task->makeRoot();
            }
        }

        // Add a subtask for each root task.
        $rootTasks = Task::roots()->get();

        foreach ($rootTasks as $rootTask) {
            $start_at = Carbon::parse($rootTask->start_at)->addDays(rand(1, 5));
            $end_at = Carbon::parse($rootTask->end_at)->subDays(rand(1, 5));

            $rootTask->children()->create([
                'name' => $faker->sentence(rand(5, 15)),
                'description' => $faker->sentence(rand(0, 100)),
                'start_at' => $start_at->toDateString(),
                'end_at' => $end_at->toDateString(),
                'user_id' => $rootTask->project->users->random(1)->id,
                'status' => 'Open',
            ]);
        }


        // Add a subtask for each tasks.
        $tasks = Task::all();

        foreach ($tasks as $task) {
            $start_at = Carbon::parse($task->start_at)->addDays(rand(1, 5));
            $end_at = Carbon::parse($task->end_at)->subDays(rand(1, 5));

            $task->children()->create([
                'name' => $faker->sentence(rand(5, 15)),
                'description' => $faker->sentence(rand(0, 100)),
                'start_at' => $start_at->toDateString(),
                'end_at' => $end_at->toDateString(),
                'user_id' => $task->project->users->random(1)->id,
                'status' => 'Open',
            ]);
        }
    }

}
