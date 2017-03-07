<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

    protected $fillable = ['content', 'task_id', 'user_id'];

    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $revisionCreationsEnabled = true;

    /**
     * Only the project manager can destroy the comments.
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
     * Get the task.
     *
     * @return type
     */
    public function task() {
        return $this->belongsTo('App\Task');
    }

    /**
     * Used by VentureCraft/Revisionable instead of the model foreign key.
     *
     * @return type
     */
    public function identifiableName() {
        return $this->content;
    }

}
