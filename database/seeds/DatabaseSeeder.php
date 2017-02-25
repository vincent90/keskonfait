<?php

use App\Comment;
use App\Project;
use App\Task;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Events\Dispatcher;

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        // Remove the event dispatchers temporarily.
        User::unsetEventDispatcher();
        Project::unsetEventDispatcher();
        Task::unsetEventDispatcher();
        Comment::unsetEventDispatcher();

        $this->call(UsersTableSeeder::class);
        $this->call(ProjectsTableSeeder::class);
        $this->call(TasksTableSeeder::class);
        $this->call(CommentsTableSeeder::class);

        // Re-add the event dispatchers.
        User::setEventDispatcher(new Dispatcher);
        Project::setEventDispatcher(new Dispatcher);
        Task::setEventDispatcher(new Dispatcher);
        Comment::setEventDispatcher(new Dispatcher);
    }

}
