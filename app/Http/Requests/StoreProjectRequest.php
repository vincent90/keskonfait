<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Lang;

class StoreProjectRequest extends FormRequest {

    /**
     * Always return true (any user can create a new project).
     *
     * @return boolean
     */
    public function authorize() {
        return true;
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
     * Automatically add the authenticated user id.
     *
     * @return array
     */
    public function all() {
        $input = parent::all();
        $input['user_id'] = Auth::id();
        $this->replace($input);
        return parent::all();
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
            }
        });
    }

}
