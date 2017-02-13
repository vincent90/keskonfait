<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreUserRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        // Only a superuser can create/update a user account.
        return Auth::user()->superuser;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'phone_number' => 'required|max:30',
            'user_image' => 'max:255',
            'discord_account' => 'max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'superuser' => 'required',
            'password' => 'required|min:6|confirmed',
        ];
    }

}
