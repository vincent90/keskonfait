<?php

namespace App\Http\Controllers;

use App\Project;
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

        return view('projects.show', [
            'project' => $project
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
        //$project = Project::findOrFail($project->id);

        $validator = Validator::make($request->all(), [
                    'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('/projects/' + $project->id + '/edit')
                            ->withInput()
                            ->withErrors($validator);
        }

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
