<?php

namespace App\Http\Requests;

use App\Task;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreCommentRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        $input = $this->all();
        $task = Task::findOrFail($input['task_id']);
        return $task->canComment(Auth::user());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'content' => 'required',
            'task_id' => 'required|exists:tasks,id',
        ];
    }

    /**
     * Get all of the input and files for the request.
     *
     * @return array
     */
    public function all() {
        $input = parent::all();
        $input['user_id'] = Auth::id();
        $this->replace($input);
        return parent::all();
    }

}
