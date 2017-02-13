<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Mail\TaskAssigned;
use App\Task;
use App\User;
use Illuminate\Support\Facades\Auth;
use Mail;

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
        $tasks = Auth::user()->tasks();

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

        // Send an email to the assigned user.
        try {
            Mail::to($task->user->email)->send(new TaskAssigned($task));
        } catch (Exception $exception) {
            
        }

        return redirect('/projects/' . $request->project_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task) {
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
        return view('tasks.edit', [
            'task' => $task,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request\StoreTaskRequest  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTaskRequest $request, Task $task) {
        $task = Task::findorfail($task->id);
        $task->name = $request->name;
        $task->description = $request->description;
        $task->start_at = $request->start_at;
        $task->end_at = $request->end_at;

        // Send an email only if the assigned user has changed.
        if ($task->user->id != $request->user_id) {
            $task->user_id = $request->user_id;
            try {
                Mail::to(User::findOrFail($request->user_id)->email)->send(new TaskAssigned($task));
            } catch (Exception $e) {
                
            }
        }

        $task->status = $request->status;
        $task->save();

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
        return redirect('/projects/' . $project->id);
    }

}
