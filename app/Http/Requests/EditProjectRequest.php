<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;

class EditProjectRequest extends FormRequest {

    /**
     * Always return true (any user can create a new project).
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
            if ($input['start_at'] > $input['end_at']) {
                $validator->errors()->add('start_at', 'End date must be greater than or equal to start date.');
                $validator->errors()->add('end_at', 'End date must be greater than or equal to start date.');
            }
        });
    }

}
