<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
use App\Exceptions\NotImplementedException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $userId = Auth::id();
        $projects = Project::getForUser($userId);

        return view('projects.index', [
            'projects' => $projects
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
    public function createTask($id) {
        $project = Project::findOrFail($id);

        return view('projects.create_task', [
            'project' => $project,
        ]);
    }

    /**
     * Create a new root task for a project.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeTask(Request $request, $id) {
        $validator = Validator::make($request->all(), [
                    'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('/projects/' . $id . '/create_task')
                            ->withInput()
                            ->withErrors($validator);
        }

        $userId = Auth::id();
        $project = Project::findOrFail($id);

        if ($project->user_id != $userId) {
            App::abort(403, 'Access denied');
        }

        $task = Task::create(['project_id' => $id, 'name' => $request->name, 'description' => $request->description, 'isComplete' => false]);

        return redirect('/projects/' . $project->id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
                    'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('/projects')
                            ->withInput()
                            ->withErrors($validator);
        }

        $projects = new Project;
        $projects->user_id = Auth::id();
        $projects->name = $request->name;
        if ($request->start_date != null) {
            $projects->start_date = $request->start_date;
        }
        if ($request->end_date != null) {
            $projects->end_date = $request->end_date;
        }
        $projects->save();

        return redirect('/projects');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project) {
        $project = Project::findOrFail($project->id);
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
        $project = Project::findOrFail($project->id);

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
    public function update(Request $request, Project $project) {
        $validator = Validator::make($request->all(), [
                    'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('projects/' . $project->id . '/edit')
                            ->withInput()
                            ->withErrors($validator);
        }

        $project->name = $request->name;
        if ($request->start_date != null) {
            $project->start_date = $request->start_date;
        }
        if ($request->end_date != null) {
            $project->end_date = $request->end_date;
        }
        $project->save();

        return redirect('/projects');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project) {
        Project::findOrFail($project->id)->delete();
        return redirect('/projects');
    }

}
