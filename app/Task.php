<?php

namespace App;

use App\User;
use Baum\Node;

class Task extends Node {

    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $fillable = ['name', 'description', 'start_at', 'end_at', 'user_id', 'status', 'project_id', 'parent_id', 'lft', 'rgt', 'depth'];
    protected $revisionCreationsEnabled = true;

    /**
     * A user assigned to a project can see all the project tasks.
     *
     * @param User $user
     * @return boolean
     */
    public function canShow(User $user) {
        return $this->project->canShow($user);
    }

    /**
     * Only the project manager or the user assigned to the task can edit the task.
     *
     * @param User $user
     * @return type
     */
    public function canEdit(User $user) {
        return $this->project->user->id == $user->id || $this->user->id == $user->id;
    }

    /**
     * Only the project manager can destroy the task.
     *
     * @param User $user
     * @return type
     */
    public function canDestroy(User $user) {
        return $this->project->user->id == $user->id;
    }

    /**
     * A user assigned to a project can comment on all the project tasks.
     *
     * @param User $user
     * @return boolean
     */
    public function canComment(User $user) {
        return $this->project->canShow($user);
    }

    /**
     * Recursively find the project for the task.
     *
     * @return type
     */
    public function project() {
        $project = $this->belongsTo('App\Project');

        if (!count($project->get())) {
            $parentTask = $this->parent;
            while (!$parentTask->isRoot()) {
                $parentTask = $parentTask->parent;
            }
            $project = $parentTask->belongsTo('App\Project');
        }

        return $project;
    }

    /**
     * Get the user assigned to the task.
     *
     * @return type
     */
    public function user() {
        return $this->belongsTo('App\User');
    }

    /**
     * Get all comments for the task.
     *
     * @return type
     */
    public function comments() {
        return $this->hasMany('App\Comment');
    }

    /**
     * Used by VentureCraft/Revisionable instead of the model foreign key.
     *
     * @return type
     */
    public function identifiableName() {
        return $this->name;
    }

}
