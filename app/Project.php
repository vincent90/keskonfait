<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Project extends Model {

    /**
     * Retrieves all projects of the specified user.
     *
     * @param type $userId id of the user
     */
    public static function getForUser($userId) {
        $projects = DB::table('projects')->where('user_id', '=', $userId)->get();
        return $projects;
    }

}
