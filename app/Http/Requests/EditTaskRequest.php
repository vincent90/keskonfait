<?php

namespace App\Http\Requests;

use App\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;

class EditTaskRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        $task = $this->route('task');
        return $task->canEdit(Auth::user());
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
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:Open,Closed',
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
                    $validator->errors()->add('start_at', 'Start date must be lesser than or equal to the end date.');
                    $validator->errors()->add('end_at', 'End date must be greater than or equal to the start date.');
                } else {
                    $parentTask = $this->route('task')->parent;

                    if ($parentTask != null) {
                        if ($input['start_at'] < $parentTask->start_at) {
                            $validator->errors()->add('start_at', 'Start date must be greater than or equal to the parent task start date.');
                        }
                        if ($input['end_at'] > $parentTask->end_at) {
                            $validator->errors()->add('end_at', 'End date must be lesser than or equal to the parent task end date.');
                        }
                    } else {
                        $project = Project::findOrFail($input['project_id']);

                        if ($input['start_at'] < $project->start_at) {
                            $validator->errors()->add('start_at', 'Start date must be greater than or equal to the project start date.');
                        }
                        if ($input['end_at'] > $project->end_at) {
                            $validator->errors()->add('end_at', 'End date must be lesser than or equal to the project end date.');
                        }
                    }
                }
            }
        });
    }

}
