<?php

use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        // Assign a few users to every project.
        $projects = App\Project::all();

        foreach ($projects as $project) {
            $min = rand(1, 12);
            $max = $min + rand(0, 14);
            $userIds = App\User::whereBetween('id', array($min, $max))->pluck('id')->toArray();

            // The project manager is added if he's not already in the list.
            $id = $project->user_id;
            if (!in_array($id, $userIds)) {
                array_push($userIds, $id);
            }

            $project->users()->sync($userIds);
        }
    }

}
