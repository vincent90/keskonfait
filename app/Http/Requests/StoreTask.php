<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTask extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
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
            'assigned_to_user_id' => 'required|exists:users,id',
            'status' => 'in:Open,Closed',
            'project_id' => 'exists:projects,id',
        ];
    }

}
