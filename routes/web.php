<?php

use App\Task;

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

// Automatically redirect to the home page (or the login form if the user is not authenticated).
Route::get('/', function () {
    return redirect('projects');
});
Route::get('/home', function () {
    return redirect('projects');
});

Auth::routes();

Route::resource('comments', 'CommentController', ['except' => [
        'index', 'create', 'show', 'edit', 'update',
]]);
Route::resource('projects', 'ProjectController', ['except' => [
        'create',
]]);
Route::resource('tasks', 'TaskController', ['except' => [
        'create',
]]);
Route::resource('users', 'UserController');
