<?php

use App\Task;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

/**
 * Display all tasks.
 */
Route::get('/tasks', function () {
  $tasks = Task::orderBy('created_at', 'asc')->get();

  return view('tasks', [
      'tasks' => $tasks
  ]);
})->middleware('auth');

/**
 * Add a new task.
 */
Route::post('/tasks', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'name' => 'required|max:255',
        'description' => 'max:255',
    ]);

    if ($validator->fails()) {
        return redirect('/tasks')
            ->withInput()
            ->withErrors($validator);
    }

    $task = new Task;
    $task->name = $request->name;
    $task->description = $request->description;
    $task->isComplete = false;
    $task->save();

    return redirect('/tasks');
})->middleware('auth');

/**
 * Delete an existing task.
 */
Route::delete('/tasks/{id}', function ($id) {
  Task::findOrFail($id)->delete();
  return redirect('/tasks');
})->middleware('auth');
