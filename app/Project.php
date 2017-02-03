<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;

class Project extends Model {

    protected $revisionCreationsEnabled = true;

    use \Venturecraft\Revisionable\RevisionableTrait;

    public static function boot() {
        parent::boot();
    }

    /**
     * Retrieve all projects of the authenticated user.
     *
     * @return type
     */
    public static function findAllForAuthenticatedManager() {
        $projects = DB::table('projects')->where('project_manager_id', '=', Auth::id())->get();
        return $projects;
    }

    /**
     * Return true only if the user is the project manager.
     *
     * @return boolean
     */
    public function canUpdate() {
        if ($this->project_manager_id == Auth::id()) {
            return true;
        }

        return false;
    }

    /**
     * Return true if the authenticated user is the manager of the project.
     * It's assumed that if the user can update a project, he can also delete it.
     *
     * @return type
     */
    public function canDelete() {
        return $this->canUpdate();
    }

    /**
     * Get the list of users for the project.
     *
     * @return type
     */
    public function users() {
        return $this->belongsToMany('App\User')
                        ->withTimestamps();
    }

    /**
     * Get the owner of the project.
     *
     * @return type
     */
    public function manager() {
        return User::findOrFail($this->project_manager_id);
    }

}
