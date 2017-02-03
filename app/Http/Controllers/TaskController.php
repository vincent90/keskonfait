<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Project;
use App\Task;

class TaskController extends Controller {

    public function __construct() {
        // Only authenticated users can access these methods.
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $tasks = Task::findAllForAuthenticatedUser();

        return view('tasks.index', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        throw new NotImplementedException();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTask $request) {
        throw new NotImplementedException();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task) {
        throw new NotImplementedException();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task) {
        $project = Project::findorfail($task->id);

        return view('tasks.edit', [
            'task' => $task,
            'project' => $project,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task) {
        // Only the project manager or the task's owner can edit the task.
        $project = Project::findorfail($task->project_id);
        if ($project->project_manager_id != Auth::id() || $task->assigned_to_user_id != Auth::id()) {
            App::abort(403, 'Access denied');
        }

        $task = Task::findorfail($task->id);
        $task->name = $request->name;
        $task->description = $request->description;
        $task->status = $request->status;
        $task->assigned_to_user_id = $request->assigned_to_user_id;

        if ($task->start_at != null) {
            $task->start_at = $request->start_at;
        }
        if ($task->end_at != null) {
            $task->end_at = $request->end_at;
        }

        $task->save();

        return redirect('/tasks/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task) {
        Task::findOrFail($task->id)->delete();
        return redirect('/projects');
    }

}
