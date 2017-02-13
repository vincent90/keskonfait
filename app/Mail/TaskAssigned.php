<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Task;

class TaskAssigned extends Mailable implements ShouldQueue {

    use Queueable,
        SerializesModels;

    public $task;

    /**
     * Create a new message instance.
     *
     * @param Task $task
     * @return void
     */
    public function __construct(Task $task) {
        $this->task = $task;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->view('emails.task_assigned');
    }

}
