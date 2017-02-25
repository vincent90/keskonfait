<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\Validator;

class StoreUserRequest extends FormRequest {

    /**
     * Only a superuser can create a new user account.
     *
     * @return bool
     */
    public function authorize() {
        return Auth::user()->superuser;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'first_name' => 'required|max:60',
            'last_name' => 'required|max:100',
            'phone_number' => 'required|max:30',
            'user_image' => 'max:255',
            'discord_user' => 'max:50|unique:users',
            'discord_channel' => 'max:50',
            'email' => 'required|email|max:255|unique:users',
            'superuser' => 'required',
            'active' => 'required',
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
            $input = $this->all();

            if ($input['discord_user'] != '' && $input['discord_channel'] == '') {
                $validator->errors()->add('discord_channel', Lang::get('validation.discord_channel_missing'));
            }
            if ($input['discord_user'] == '' && $input['discord_channel'] != '') {
                $validator->errors()->add('discord_user', Lang::get('validation.discord_user_missing'));
            }
        });
    }

}
