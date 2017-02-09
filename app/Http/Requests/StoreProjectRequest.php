<?php

namespace App\Http\Requests;

use Carbon\Carbon;
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

    public function all() {
        $attributes = parent::all();

        $attributes['user_id'] = Auth::id();

//        $start_at = $attributes['start_at'];
//        $attributes['start_at'] = !empty($start_at) ? $attributes['start_at'] : null;
//
//        $end_at = $attributes['end_at'];
//        $attributes['end_at'] = !empty($end_at) ? $attributes['end_at'] : null;

        $this->replace($attributes);
        return parent::all();
    }

}
