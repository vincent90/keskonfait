<?php

namespace App\Http\Controllers;

use App;
use App\Exceptions\NotImplementedException;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\StoreTaskRequest;
use App\Mail\TaskAssigned;
use App\Project;
use App\Task;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Mail;

class ProjectController extends Controller {

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
//        $projects = Auth::user()->projects;
        $projects = Project::where('user_id', Auth::id())->get();
        $users = User::all()->except(Auth::id());

        return view('projects.index', [
            'projects' => $projects,
            'users' => $users,
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
     * Show the form for creating a new root task for a project.
     *
     * @return \Illuminate\Http\Response
     */
    public function createTask(Project $project) {
        return view('projects.create_task', [
            'project' => $project,
        ]);
    }

    /**
     * Create a new root task for a project.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeTask(StoreTaskRequest $request, Project $project) {
        // Only the project manager can add root tasks.
        if (!$project->canUpdate(Auth::user())) {
            App::abort(403, 'Access denied');
        }

        $task = Task::create([
                    'name' => $request->name,
                    'description' => $request->description,
                    'start_at' => $request->start_at,
                    'end_at' => $request->end_at,
                    'user_id' => $request->user_id,
                    'status' => $request->status,
                    'project_id' => $project->id,
        ]);

        $task->save();

        // Send an email to the assigned user.
        try {
            Mail::to(User::findOrFail($task->user_id)->email)->send(new TaskAssigned($task));
        } catch (Exception $e) {
            
        }

        return redirect('/projects/' . $project->id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request) {
        $project = Project::create($request->all());

        if (Input::get('users') != null) {
            $project->users()->sync($request->users);
        }

        return redirect('/projects');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project) {
        return view('projects.show', [
            'project' => $project,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project) {
        $users = User::all()->except(Auth::id());
        return view('projects.edit', [
            'project' => $project,
            'users' => $users,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProjectRequest $request, Project $project) {
        if (!$project->canUpdate(Auth::user())) {
            App::abort(403, 'Access denied');
        }

        $projects = Project::findOrFail($project->id);
        $projects->name = $request->name;
        $projects->description = $request->description;
        $projects->start_at = $request->start_at;
        $projects->end_at = $request->end_at;
        $projects->save();

        if (Input::get('users') != null) {
            $projects->users()->sync(Input::get('users'));
        }

        return redirect('/projects/' . $project->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project) {
        if (!$project->canDelete(Auth::user())) {
            App::abort(403, 'Access denied');
        }

        Project::findOrFail($project->id)->delete();
        return redirect('/projects');
    }

}
