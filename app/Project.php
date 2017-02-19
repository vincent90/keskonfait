<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Project extends Model {

    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $fillable = ['name', 'description', 'start_at', 'end_at', 'user_id'];
    protected $revisionCreationsEnabled = true;

    /**
     * Return true if the user can see the project. Any user assigned to a project can see the project's details.
     *
     * @param User $user
     * @return boolean
     */
    public function canShow(User $user) {
        return $this->users->pluck('id')->contains($user->id);
    }

    /**
     * Return true if the user can edit the project. Only the project manager can edit the project.
     * 
     * @param User $user
     * @return boolean
     */
    public function canEdit(User $user) {
        return $this->user_id == $user->id;
    }

    /**
     * Return true if the user can add task.
     *
     * @param User $user
     * @return type
     */
    public function canAddTasks(User $user) {
        return $this->users->pluck('id')->contains($user->id);
    }

    /**
     * Return true if the user can destroy the project. Only the project manager can destroy the project.
     *
     * @param User $user
     * @return type
     */
    public function canDestroy(User $user) {
        return $this->user_id == $user->id;
    }

    /**
     * Get the users in the project.
     *
     * @return type
     */
    public function users() {
        return $this->belongsToMany('App\User')->withTimestamps();
    }

    /**
     * Get the project manager.
     *
     * @return type
     */
    public function user() {
        return $this->belongsTo('App\User');
    }

    /**
     * Get all tasks and subtasks of the project.
     *
     * @return type
     */
    public function tasks() {
        return $this->hasMany('App\Task');
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
