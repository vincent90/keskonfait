<?php

use App\Comment;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $faker = Faker\Factory::create();

        // Add a few comments to every tasks.
        $tasks = App\Task::all();

        foreach ($tasks as $task) {
            for ($i = 0; $i < rand(0, 5); $i++) {
                Comment::create([
                    'content' => $faker->sentence(rand(10, 100)),
                    'task_id' => $task->id,
                    'user_id' => $task->project->users->random(1)->id,
                ]);
            }
        }
    }

}
