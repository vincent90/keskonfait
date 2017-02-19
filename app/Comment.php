<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $fillable = ['content', 'task_id', 'user_id'];
    protected $revisionCreationsEnabled = true;

    /**
     * Return true if the user can destroy the comment. Only the project manager can destroy a comment.
     *
     * @param User $user
     * @return type
     */
    public function canDestroy(User $user) {
        return $this->task->project->user->id == $user->id;
    }

    /**
     * Get the user who made the comment.
     *
     * @return type
     */
    public function user() {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the task on which the comment was made.
     *
     * @return type
     */
    public function task() {
        return $this->belongsTo('App\Task');
    }

    /**
     * Used by VentureCraft/Revisionable.
     *
     * @return type
     */
    public function identifiableName() {
        return $this->content;
    }

}
