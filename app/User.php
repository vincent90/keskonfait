<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {

    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'phone_number', 'user_image', 'discord_account', 'email', 'superuser', 'password',
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
     * Get the user's projects.
     *
     * @return type
     */
    public function projects() {
//        return $this->hasMany('App\Project');
        return $this->belongsToMany('App\Project')->withTimestamps();
    }

    /**
     * Get the user's tasks.
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
        return $this->fullName();
    }

    /**
     * Return the full name of the user.
     *
     * @return type
     */
    public function fullName() {
        return $this->first_name . ' ' . $this->last_name;
    }

}
