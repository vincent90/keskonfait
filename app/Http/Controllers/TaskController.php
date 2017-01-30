<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // $tasks = Task::orderBy('created_at', 'asc')->get();
      $tasks = Task::roots()->with('children')->get();

    // $node->descendants()->limitDepth(5)->get();

      $items = Task::all(['id', 'name']);
      return view('tasks.index', [
          'tasks' => $tasks,
          'items' => $items
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
           'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('/tasks')
                ->withInput()
                ->withErrors($validator);
        }

        // $selectId = $request->input('item_id');
        // $parentTask = Task::findOrFail(2);
        //
        // $task = $parentTask->children()->create(['name' => $request->name, 'description' => $request->description, 'isComplete' => false]);

        $task = Task::create(['name' => $request->name, 'description' => $request->description, 'isComplete' => false]);
        // $task->parent_id = null;
        // $task->name = $request->name;
        // $task->description = $request->description;
        // $task->isComplete = false;
        // $task->save();

        return redirect('/tasks');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
      Task::findOrFail($task->id)->delete();
      return redirect('/tasks');
    }
}
