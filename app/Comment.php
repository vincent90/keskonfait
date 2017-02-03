<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Task;
use App\User;

class Comment extends Model {

    /**
     * Retrieve all comments for a task.
     *
     * @return type
     */
    public static function findAllForTask(Task $task) {
        $projects = DB::table('comments')->where('task_id', '=', $task->id)->get();
        return $projects;
    }

    /**
     * Get the user who made the comment.
     *
     * @return type
     */
    public function user() {
        return User::findOrFail($this->user_id);
    }

}
