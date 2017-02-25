<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\Validator;

class EditUserPasswordRequest extends FormRequest {

    /**
     * A user can only update his own password.
     *
     * @return bool
     */
    public function authorize() {
        $user = $this->route('user');
        return Auth::id() == $user->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'old_password' => 'required|min:6',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
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
            $user = $this->route('user');
            $input = $this->all();

            if ($input['old_password'] != '' && $input['password'] != '' && $input['password_confirmation']) {
                $check = auth()->validate([
                    'email' => $user->email,
                    'password' => $input['old_password']
                ]);

                if (!$check) {
                    $validator->errors()->add('old_password', Lang::get('validation.wrong_password'));
                }
            }
        });
    }

}
