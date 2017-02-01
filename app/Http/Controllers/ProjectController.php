<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProject;
use App\Http\Requests\StoreTask;
use App\Exceptions\NotImplementedException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Project;
use App\Task;
use App\User;

class ProjectController extends Controller {

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
        $projects = Project::findAllForAuthenticatedManager();

        $users = User::all();
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
    public function storeTask(StoreTask $request, Project $project) {
        // Only the project manager can add root tasks.
        if ($project->project_manager_id != Auth::id()) {
            App::abort(403, 'Access denied');
        }

        $task = Task::create([
                    'name' => $request->name,
                    'description' => $request->description,
                    'status' => $request->status,
                    'project_id' => $project->id,
        ]);

        if ($task->start_at != null) {
            $task->start_at = $request->start_at;
        }
        if ($task->end_at != null) {
            $task->end_at = $request->end_at;
        }
        $task->save();

        return redirect('/projects/' . $project->id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProject $request) {
        $projects = new Project;
        $projects->name = $request->name;
        $projects->description = $request->description;
        if ($request->start_at != null) {
            $projects->start_at = $request->start_at;
        }
        if ($request->end_at != null) {
            $projects->end_at = $request->end_at;
        }
        $projects->project_manager_id = Auth::id();
        $projects->save();

        if (Input::get('users') != null) {
            $projects->users()->sync(Input::get('users'));
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
        $tasks = Task::roots()->where('project_id', '=', $project->id)->with('children')->get();

        return view('projects.show', [
            'project' => $project,
            'tasks' => $tasks,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project) {
        return view('projects.edit', [
            'project' => $project
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProject $request, Project $project) {
        if (!$project->canUpdate()) {
            abort(403, 'Access denied.');
        }

        $projects = Project::findOrFail($project->id);
        $projects->name = $request->name;
        $projects->description = $request->description;
        if ($request->start_at != null) {
            $projects->start_at = $request->start_at;
        }
        if ($request->end_at != null) {
            $projects->end_at = $request->end_at;
        }
        $projects->project_manager_id = Auth::id();
        $projects->save();

        return redirect('/projects');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project) {
        if (!$project->canDelete()) {
            abort(403, 'Access denied.');
        }

        Project::findOrFail($project->id)->delete();
        return redirect('/projects');
    }

}
