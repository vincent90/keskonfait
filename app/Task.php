<?php

namespace App;

use App\User;
use Baum\Node;

/**
 * Task
 */
class Task extends Node {

    protected $fillable = ['name', 'description', 'start_at', 'end_at', 'user_id', 'status', 'project_id', 'parent_id', 'lft', 'rgt', 'depth'];
    protected $revisionCreationsEnabled = true;

    use \Venturecraft\Revisionable\RevisionableTrait;

    public static function boot() {
        parent::boot();
    }

    /**
     * Return true if the user can see the task. Any user assigned to a project can see the project's tasks.
     *
     * @param User $user
     * @return boolean
     */
    public function canShow(User $user) {
        return collect($this->project->userIds())->contains($user->id);
    }

    /**
     * Return true if the user can edit the task. Any user assigned to a project can edit the project's tasks.
     *
     * @param User $user
     * @return type
     */
    public function canEdit(User $user) {
        return collect($this->project->userIds())->contains($user->id);
    }

    /**
     * Return true if the user can destroy the task. Only the project manager can destroy a task.
     *
     * @param User $user
     * @return type
     */
    public function canDestroy(User $user) {
        return $this->project->user->id == $user->id;
    }

    /**
     * If a user can see a task, he can also comment it.
     *
     * @param User $user
     * @return boolean
     */
    public function canComment(User $user) {
        return $this->canShow($user);
    }

    /**
     * Recursively find the project.
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
     * Get the comments for the task.
     *
     * @return type
     */
    public function comments() {
        return $this->hasMany('App\Comment');
    }

    /**
     * Used by VentureCraft/Revisionable.
     *
     * @return type
     */
    public function identifiableName() {
        return $this->name;
    }

}
