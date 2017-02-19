<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EditUserRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
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
        return [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'phone_number' => 'required|max:30',
            'user_image' => 'max:255',
            'discord_user' => 'max:255|unique:users',
            'discord_channel' => 'max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->route('user')->id,
            'superuser' => 'required',
            'active' => 'required',
        ];
    }

}
