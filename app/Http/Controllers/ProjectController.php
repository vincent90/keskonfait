<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditProjectRequest;
use App\Http\Requests\StoreProjectRequest;
use App\Project;
use App\Task;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Lang;

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
        $projects = Auth::user()->projects()->orderBy('start_at', 'asc')->orderBy('end_at', 'asc')->get();
        $users = User::orderBy('first_name', 'asc')->orderBy('last_name', 'asc')->get()->except(Auth::id());

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
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request) {
        $project = Project::create($request->all());

        // Sync the many-to-many relationship.
        if (Input::get('users') == null) {
            $users = [];
        } else {
            $users = Input::get('users');
        }
        array_push($users, Auth::id()); // Automatically add the authenticated user.
        $project->users()->sync($users);

        $request->session()->flash('alert-success', Lang::get('controller.store_project'));
        return redirect('/projects/' . $project->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project) {
        if (!$project->canShow(Auth::user())) {
            abort(403, 'Access denied');
        }

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
        if (!$project->canEdit(Auth::user())) {
            abort(403, 'Access denied');
        }

        $users = User::orderBy('first_name', 'asc')->orderBy('last_name', 'asc')->get()->except(Auth::id());

        return view('projects.edit', [
            'project' => $project,
            'users' => $users,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  EditProjectRequest  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(EditProjectRequest $request, Project $project) {
        $projects = Project::findOrFail($project->id);
        $projects->name = $request->name;
        $projects->description = $request->description;
        $projects->start_at = $request->start_at;
        $projects->end_at = $request->end_at;
        $projects->save();

        // Sync the many-to-many relationship.
        if (Input::get('users') == null) {
            $users = [];
        } else {
            $users = Input::get('users');
        }
        array_push($users, Auth::id()); // Automatically add the authenticated user.
        $project->users()->sync($users);

        $request->session()->flash('alert-success', Lang::get('controller.edit_project'));
        return redirect('/projects/' . $project->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project) {
        if (!$project->canDestroy(Auth::user())) {
            abort(403, 'Access denied');
        }

        $children = Task::root()->where('project_id', $project->id)->get();
        foreach ($children as $t) {
            $t->delete();
        }

        Project::findOrFail($project->id)->delete();

        session()->flash('alert-success', Lang::get('controller.destroy_project'));
        return redirect('/projects');
    }

}
