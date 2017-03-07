<?php

use App\Comment;
use App\Task;
use App\User;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $faker = Faker\Factory::create();
        $tasks = Task::all();

        foreach ($tasks as $task) {
            // add between 0 and 5 comments to each task by a random user in the project
            for ($i = 0; $i < rand(0, 5); $i++) {
                $user = User::findorfail($task->project->users->random(1)->id);
                Auth::login($user);

                Comment::create([
                    'content' => $faker->sentence(rand(10, 100)),
                    'task_id' => $task->id,
                    'user_id' => $user->id,
                ]);

                Auth::logout();
            }
        }
    }

}
