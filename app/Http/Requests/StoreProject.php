<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProject extends FormRequest {

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
            'start_at' => 'date|date_format:Y-m-d',
            'end_at' => 'date|date_format:Y-m-d|after:start_at',
        ];
    }

}
