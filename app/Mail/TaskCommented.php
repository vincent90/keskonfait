<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Task;
use App\Comment;

class TaskCommented extends Mailable {

    use Queueable,
        SerializesModels;

    public $task;
    public $comment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Task $task, Comment $comment) {
        $this->task = $task;
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->view('emails.comment');
    }

}
