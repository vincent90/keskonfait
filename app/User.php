<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The projects that belong to the user.
     */
    public function projects() {
        return $this->belongsToMany('App\Project')->withTimestamps();
    }

    /**
     * Get the tasks for the user.
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

}
