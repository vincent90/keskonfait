<?php

use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        // Add a list of tasks for every project.
        $projects = App\Project::all();
        foreach ($projects as $project) {
            for ($i = 1; $i < rand(3, 10); $i++) {
                $project->tasks()->save(factory(App\Task::class)->make([
                            'user_id' => $project->users->random(1)->id,
                            'project_id' => $project->id,]));
            }
        }
    }

}
