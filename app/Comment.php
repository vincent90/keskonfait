<?php

namespace App;

use App\Task;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

    protected $fillable = ['content', 'task_id', 'user_id'];
    protected $revisionCreationsEnabled = true;

    use \Venturecraft\Revisionable\RevisionableTrait;

    public static function boot() {
        parent::boot();
    }

    /**
     * Get the user that made the comment.
     */
    public function user() {
        return $this->belongsTo('App\User');
    }

    /**
     * Return true only if the user can update the comment.
     *
     * @return boolean
     */
    public function canUpdate(User $user) {
        if ($this->user_id == $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Return true only if the user can delete the comment.
     *
     * @return type
     */
    public function canDelete(User $user) {
        return $this->canUpdate($user);
    }

    /**
     * Used by VentureCraft/Revisionable
     *
     * @return type
     */
    public function identifiableName() {
        return $this->content;
    }

}
