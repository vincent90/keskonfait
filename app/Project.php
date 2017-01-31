<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Project extends Model {

    /**
     * Retrieves all projects of the specified manager.
     *
     * @param type $managerId
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
     * Return true if the authenticated user is the manager of the project. It's assumed that if the user can update a project, he can also delete it.
     *
     * @return type
     */
    public function canDelete() {
        return $this->canUpdate();
    }

}
