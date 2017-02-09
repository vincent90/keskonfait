<?php

namespace App\Http\Controllers;

use App;
use App\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Mail\TaskAssigned;
use App\Project;
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
        $tasks = Auth::user()->tasks()->orderBy('start_at', 'asc')->get();

        return view('tasks.index', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * Create a new comment for a task.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeComment(StoreCommentRequest $request, Task $task) {
        $comment = new Comment;
        $comment->content = $request->content;
        $comment->task_id = $task->id;
        $comment->user_id = Auth::id();
        $comment->save();

        return redirect('/tasks/' . $task->id);
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
    public function store(StoreTaskRequest $request) {
        throw new NotImplementedException();
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
        // Only the project manager or the task's owner can edit the task.
        if (!$task->canUpdate(Auth::user())) {
            App::abort(403, 'Access denied');
        }

        $task = Task::findorfail($task->id);
        $task->name = $request->name;
        $task->description = $request->description;
        $task->start_at = $request->start_at;
        $task->end_at = $request->end_at;

        // Send an email only if the user changed.
        if ($task->user->id != $request->user_id) {
            $task->user_id = $request->user_id;
            try {
                Mail::to(User::findOrFail($task->user_id)->email)->send(new TaskAssigned($task));
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
        if (!$task->canDelete(Auth::user())) {
            App::abort(403, 'Access denied');
        }

        $project = $task->project;
        Task::findOrFail($task->id)->delete();
        return redirect('/projects/' . $project->id);
    }

    /**
     * Remove the specified comment.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroyComment(Task $task, Comment $comment) {
        Comment::findOrFail($comment->id)->delete();
        return redirect('/tasks/' . $task->id);
    }

}
