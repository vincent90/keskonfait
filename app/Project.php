<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Project extends Model {

    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $fillable = ['name', 'description', 'start_at', 'end_at', 'user_id'];
    protected $revisionCreationsEnabled = true;

    /**
     * Any user assigned to the project can access the project's detail.
     *
     * @param User $user
     * @return boolean
     */
    public function canShow(User $user) {
        return $this->users->pluck('id')->contains($user->id);
    }

    /**
     * Only the project manager can edit the project.
     * 
     * @param User $user
     * @return boolean
     */
    public function canEdit(User $user) {
        return $this->user_id == $user->id;
    }

    /**
     * Any user assigned to the project can add new task in the project.
     *
     * @param User $user
     * @return type
     */
    public function canAddTasks(User $user) {
        return $this->users->pluck('id')->contains($user->id);
    }

    /**
     * Only the project manager can destroy the project.
     *
     * @param User $user
     * @return type
     */
    public function canDestroy(User $user) {
        return $this->user_id == $user->id;
    }

    /**
     * Get the users assigned to the project.
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
     * Get all root tasks of the project.
     *
     * @return type
     */
    public function tasks() {
        return $this->hasMany('App\Task');
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
