<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditTaskRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $tasks = Auth::user()->tasks()->orderBy('start_at', 'asc')->orderBy('end_at', 'asc')->get();

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
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreTaskRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskRequest $request) {
        if ($request->task_id == '-1') {
            $task = Task::create([
                        'name' => $request->name,
                        'description' => $request->description,
                        'start_at' => $request->start_at,
                        'end_at' => $request->end_at,
                        'user_id' => $request->user_id,
                        'status' => $request->status,
                        'project_id' => $request->project_id,
            ]);
        } else {
            $rootTask = Task::findOrFail($request->task_id);
            $task = $rootTask->children()->create([
                'name' => $request->name,
                'description' => $request->description,
                'start_at' => $request->start_at,
                'end_at' => $request->end_at,
                'user_id' => $request->user_id,
                'status' => $request->status,
            ]);
        }

        session()->flash('alert-success', 'Task has been created successfully!');
        return redirect('/projects/' . $request->project_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task) {
        if (!$task->canShow(Auth::user())) {
            abort(403, 'Access denied');
        }

        return view('tasks.show', [
            'task' => $task,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task) {
        if (!$task->canEdit(Auth::user())) {
            abort(403, 'Access denied');
        }

        return view('tasks.edit', [
            'task' => $task,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  EditTaskRequest  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(EditTaskRequest $request, Task $task) {
        $task = Task::findorfail($task->id);
        $task->name = $request->name;
        $task->description = $request->description;
        $task->start_at = $request->start_at;
        $task->end_at = $request->end_at;
        $task->user_id = $request->user_id;
        $task->status = $request->status;
        $task->save();

        session()->flash('alert-success', 'Task has been updated successfully!');
        return redirect('/tasks/' . $task->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task) {
        if (!$task->canDestroy(Auth::user())) {
            abort(403, 'Access denied');
        }

        $project = $task->project;
        Task::findOrFail($task->id)->delete();

        session()->flash('alert-success', 'Task has been deleted successfully!');
        return redirect('/projects/' . $project->id);
    }

    /**
     * Close the task.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function close(Task $task) {
        if (!$task->canEdit(Auth::user())) {
            abort(403, 'Access denied');
        }

        $task = Task::findorfail($task->id);
        $task->status = 'Closed';
        $task->save();

        session()->flash('alert-success', 'Task has been closed successfully!');
        return redirect('/tasks/');
    }

}
