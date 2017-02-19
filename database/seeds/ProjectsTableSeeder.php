<?php

use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        // Add a list of users for every project.
        $projects = App\Project::all();
        foreach ($projects as $project) {
            $min = rand(1, 5);
            $max = $min + rand(2, 10);
            $userIds = App\User::whereBetween('id', array($min, $max))->pluck('id')->toArray();
            $project->users()->sync($userIds);
        }
    }

}
