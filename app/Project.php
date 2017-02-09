<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Project extends Model {

    protected $fillable = ['name', 'description', 'start_at', 'end_at', 'user_id'];
    protected $revisionCreationsEnabled = true;

    use \Venturecraft\Revisionable\RevisionableTrait;

    public static function boot() {
        parent::boot();
    }

    /**
     * Return true only if the user is the project manager.
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
     * Return true if the user is the manager of the project.
     * It's assumed that if a user can update a project, he can also delete it.
     *
     * @return type
     */
    public function canDelete(User $user) {
        return $this->canUpdate($user);
    }

    /**
     * The users that belong to the project.
     */
    public function users() {
        return $this->belongsToMany('App\User')->withTimestamps();
    }

    /**
     * Get the user that owns the project.
     */
    public function user() {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the tasks for the project.
     */
    public function tasks() {
        return $this->hasMany('App\Task');
    }

    /**
     * Used by VentureCraft/Revisionable
     *
     * @return type
     */
    public function identifiableName() {
        return $this->name;
    }

    public function getUserIdsAttribute() {
        return $this->users->pluck('id');
    }

}
