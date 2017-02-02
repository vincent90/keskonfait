<?php

namespace App;

use Baum\Node;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;

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
        $tasks = DB::table('tasks')->where('assigned_to_user_id', '=', Auth::id())->get();
        return $tasks;
    }

}
