<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\Validator;

class EditUserRequest extends FormRequest {

    /**
     * A normal user can only update his own account. A superuser can update any other account.
     *
     * @return bool
     */
    public function authorize() {
        $user = $this->route('user');
        return Auth::user()->superuser || Auth::id() == $user->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $user = $this->route('user');

        return [
            'first_name' => 'required|max:60',
            'last_name' => 'required|max:100',
            'phone_number' => 'required|max:30',
            'user_image' => 'max:255',
            'discord_user' => 'max:50|unique:users,discord_user,' . $user->id,
            'discord_channel' => 'max:50',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
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

            if ($user->superuser) {
                if (!isset($input['superuser'])) {
                    $validator->errors()->add('superuser', Lang::get('validation.superuser_missing'));
                }
                if (!isset($input['active'])) {
                    $validator->errors()->add('active', Lang::get('validation.active_missing'));
                }
            }

            if ($input['discord_user'] != '' && $input['discord_channel'] == '') {
                $validator->errors()->add('discord_channel', Lang::get('validation.discord_channel_missing'));
            }
            if ($input['discord_user'] == '' && $input['discord_channel'] != '') {
                $validator->errors()->add('discord_user', Lang::get('validation.discord_user_missing'));
            }
        });
    }

}
