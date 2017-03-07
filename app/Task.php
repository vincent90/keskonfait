<?php

namespace App;

use App\Notifications\TaskAssignedNotification;
use App\User;
use Baum\Node;

class Task extends Node {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'start_at', 'end_at',
        'user_id', 'status',
        'project_id',
        'parent_id',
        'lft',
        'rgt',
        'depth'
    ];

    use \Venturecraft\Revisionable\RevisionableTrait;

    protected $revisionCreationsEnabled = true;
    // used by the notifications (a notification is sent only if the assigned user changes)
    private $originalUser = null;
    private $isNew = true;

    /**
     * A user assigned to a project can see all the project tasks.
     *
     * @param User $user
     * @return boolean
     */
    public function canShow(User $user) {
        return $this->project->canShow($user);
    }

    /**
     * Only the project manager or the user assigned to the task can edit the task.
     *
     * @param User $user
     * @return type
     */
    public function canEdit(User $user) {
        return $this->project->user->id == $user->id || $this->user->id == $user->id;
    }

    /**
     * Only the project manager can destroy the task.
     *
     * @param User $user
     * @return type
     */
    public function canDestroy(User $user) {
        return $this->project->user->id == $user->id;
    }

    /**
     * A user assigned to a project can comment on all the project tasks.
     *
     * @param User $user
     * @return boolean
     */
    public function canComment(User $user) {
        return $this->project->canShow($user);
    }

    /**
     * Recursively find the project for the task.
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
     * Get all comments for the task.
     *
     * @return type
     */
    public function comments() {
        return $this->hasMany('App\Comment');
    }

    /**
     * Used by VentureCraft/Revisionable instead of the model foreign key.
     *
     * @return type
     */
    public function identifiableName() {
        return $this->name;
    }

    /**
     * Save the model to the database.
     *
     * @param  array  $options
     * @return bool
     */
    public function save(array $options = []) {
        $query = $this->newQueryWithoutScopes();

        // If the "saving" event returns false we'll bail out of the save and return
        // false, indicating that the save failed. This provides a chance for any
        // listeners to cancel save operations if validations fail or whatever.
        if ($this->fireModelEvent('saving') === false) {
            return false;
        }

        // If the model already exists in the database we can just update our record
        // that is already in this database using the current IDs in this "where"
        // clause to only update this model. Otherwise, we'll just insert them.
        if ($this->exists) {
            $this->isNew = false;

            // get the originally assigned user (only if a new user is assigned to the task)
            if ($this->isDirty(['user_id'])) {
                $this->originalUser = $this->getOriginal('user_id');
            }

            $saved = $this->isDirty() ?
                    $this->performUpdate($query) : true;
        }

        // If the model is brand new, we'll insert it into our database and set the
        // ID attribute on the model to the value of the newly inserted row's ID
        // which is typically an auto-increment value managed by the database.
        else {
            $saved = $this->performInsert($query);
        }

        if ($saved) {
            $this->finishSave($options);
        }

        return $saved;
    }

    /**
     * Finish processing on a successful save operation.
     *
     * @param  array  $options
     * @return void
     */
    protected function finishSave(array $options) {
        parent::finishSave($options);

        if (config('app.enable_notifications')) {
            // send a notification to the assigned user
            if ($this->isNew || $this->originalUser != null) {
                $this->user->notify(new TaskAssignedNotification($this, $this->originalUser, $this->isNew));
            }
        }
    }

}
