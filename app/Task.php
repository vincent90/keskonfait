<?php

namespace App;

use App\User;
use Baum\Node;

/**
 * Task
 */
class Task extends Node {

    protected $fillable = ['name', 'description', 'start_at', 'end_at', 'user_id', 'status', 'project_id'];
    protected $revisionCreationsEnabled = true;

    use \Venturecraft\Revisionable\RevisionableTrait;

    public static function boot() {
        parent::boot();
    }

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'tasks';

    /**
     * Get the comments for the task.
     */
    public function comments() {
        return $this->hasMany('App\Comment');
    }

    /**
     * Return true only if the user can update the task (if he owns the projet).
     *
     * @return boolean
     */
    public function canUpdate(User $user) {
        if ($this->project->user_id == $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Return true only if the user can delete the task.
     *
     * @return type
     */
    public function canDelete(User $user) {
        return $this->canUpdate($user);
    }

    /**
     * Get the user that owns the task.
     */
    public function user() {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the project of the task.
     */
    public function project() {
        return $this->belongsTo('App\Project');
    }

    /**
     * Used by VentureCraft/Revisionable
     *
     * @return type
     */
    public function identifiableName() {
        return $this->name;
    }

}
