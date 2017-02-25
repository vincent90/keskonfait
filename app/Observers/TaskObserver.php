<?php

namespace App\Observers;

use App\Notifications\TaskAssignedNotification;
use App\Task;

class TaskObserver {

    /**
     * Send a notification to the user assigned to the task.
     *
     * @param  Task  $task
     * @return void
     */
    public function saved(Task $task) {
        $task->user->notify(new TaskAssignedNotification($task));
    }

}
