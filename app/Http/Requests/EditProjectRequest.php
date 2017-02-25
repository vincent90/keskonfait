<?php

namespace App\Http\Requests;

use App\Task;
use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Lang;

class EditProjectRequest extends FormRequest {

    /**
     * Only the project manager can edit the project.
     *
     * @return boolean
     */
    public function authorize() {
        $project = $this->route('project');
        return $project->canEdit(Auth::user());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'name' => 'required|max:255',
            'start_at' => 'required',
            'end_at' => 'required',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  Validator  $validator
     * @return void
     */
    public function withValidator(Validator $validator) {
        $validator->after(function ($validator) {
            $input = $this->all();


            if ($input['start_at'] != '' && $input['end_at'] != '') {
                if ($input['start_at'] > $input['end_at']) {
                    $validator->errors()->add('start_at', Lang::get('validation.start_at_must_be_smaller_than_end_at'));
                    $validator->errors()->add('end_at', Lang::get('validation.end_at_must_be_greater_than_start_at'));
                }

                $project = $this->route('project');
                $rootTasks = Task::where('project_id', $project->id)->get();

                foreach ($rootTasks as $task) {
                    if ($input['start_at'] > $task->start_at) {
                        $validator->errors()->add('start_at', Lang::get('validation.start_at_must_be_smaller_than_tasks_start_date'));
                    }
                    if ($input['end_at'] < $task->end_at) {
                        $validator->errors()->add('end_at', Lang::get('validation.end_at_must_be_smaller_than_tasks_end_date'));
                    }
                }
            }

            if (!isset($input['users'])) {
                $users = [];
            } else {
                $users = $input['users'];
            }
            array_push($users, Auth::id()); // Automatically add the authenticated user.

            foreach ($project->tasks as $task) {
                if (in_array($task->user_id, $users) == 0) {
                    $validator->errors()->add('users', 'Impossible to remove a user (' . User::findorfail($task->user_id)->fullName() . ') who have been assigned to a task.');
                }

                $subTasks = $task->children()->get();
                if (count($subTasks) > 0) {
                    foreach ($subTasks as $t) {
                        if (in_array($t->user_id, $users) == 0) {
                            $validator->errors()->add('users', 'Impossible to remove a user (' . User::findorfail($t->user_id)->fullName() . ') who have been assigned to a task.');
                        }
                    }
                }
            }
        });
    }

}
