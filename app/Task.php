<?php

namespace App;

use Baum\Node;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Project;

/**
 * Task
 */
class Task extends Node {

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'tasks';

    /**
     * Get the user associated with this task.
     *
     * @return type
     */
    public function assignedTo() {
        return User::findOrFail($this->assigned_to_user_id);
    }

    /**
     * Get all tasks of a specified user.
     *
     * @return type
     */
    public static function findAllForAuthenticatedUser() {
        return Task::where('assigned_to_user_id', '=', Auth::id())->get();
    }

    /**
     * Get all comments of the task.
     *
     * @return type
     */
    public function comments() {
        $comments = Comment::where('task_id', '=', $this->id)->get();
        return $comments;
    }

    /**
     * Get the project of the task.
     *
     * @return type
     */
    public function project() {
        return Project::findOrFail($this->project_id);
    }

}
