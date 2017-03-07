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
        'first_name',
        'last_name',
        'phone_number',
        'user_image',
        'discord_user',
        'discord_channel',
        'email',
        'superuser',
        'active',
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
     * Return the full name of the user.
     *
     * @return type
     */
    public function fullName() {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Get the user's projects.
     *
     * @return type
     */
    public function projects() {
        return $this->belongsToMany('App\Project')->withTimestamps();
    }

    /**
     * Route notifications for the Discord channel.
     *
     * @return type
     */
    public function routeNotificationForDiscord() {
        return $this->discord_channel;
    }

    /**
     * Route notifications for the mail channel.
     *
     * @return string
     */
    public function routeNotificationForMail() {
        return $this->email;
    }

    /**
     * Get all the user tasks.
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
        return $this->fullName();
    }

}
