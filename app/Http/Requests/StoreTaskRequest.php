<?php

namespace App\Http\Requests;

use App\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreTaskRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        $input = $this->all();
        return Project::findOrFail($input['project_id'])->canEdit(Auth::user());
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
            'parent_id' => 'exists:tasks,id',
        ];
    }

}
