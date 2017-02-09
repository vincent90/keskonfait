<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest {

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
            'start_at' => 'required|date|date_format:Y-m-d',
            'end_at' => 'required|date|date_format:Y-m-d|after:start_at',
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:Open,Closed',
            'project_id' => 'exists:projects,id',
        ];
    }

    public function all() {
        $attributes = parent::all();

        $start_at = $attributes['start_at'];
        $attributes['start_at'] = !empty($start_at) ? $attributes['start_at'] : null;

        $end_at = $attributes['end_at'];
        $attributes['end_at'] = !empty($end_at) ? $attributes['end_at'] : null;

        $this->replace($attributes);
        return parent::all();
    }

}
