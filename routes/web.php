<?php

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

// Login, Logout and other Laravel buit-in routes
Auth::routes();

// Comment routes
Route::resource('comments', 'CommentController', ['except' => [
        'index', 'create', 'show', 'edit', 'update',
]]);

// Project routes
Route::resource('projects', 'ProjectController', ['except' => [
        'create',
]]);

// Task routes
Route::put('tasks/{task}/close', 'TaskController@close');
Route::resource('tasks', 'TaskController', ['except' => [
        'create',
]]);

// User routes (except Login and Logout)
Route::get('users/{user}/edit_password', 'UserController@editPassword');
Route::put('users/{user}/edit_password', 'UserController@updatePassword');
Route::resource('users', 'UserController');
