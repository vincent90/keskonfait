<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

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
            'start_at' => 'required|date|date_format:Y-m-d',
            'end_at' => 'required|date|date_format:Y-m-d|after:start_at',
        ];
    }

    /**
     * Get all of the input and files for the request.
     *
     * @return array
     */
    public function all() {
        $input = parent::all();

        $userId = Auth::id();
        $input['user_id'] = $userId;

        $this->replace($input);
        return parent::all();
    }

}
