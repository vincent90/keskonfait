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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('projects/{project}/create_task', 'ProjectController@createTask')->name('project.create_task');
Route::post('projects/{project}/create_task', 'ProjectController@storeTask')->name('project.store_task');
Route::resource('projects', 'ProjectController');

Route::resource('tasks', 'TaskController');
Route::post('tasks/{task}/create_comment', 'TaskController@storeComment')->name('task.store_comment');
Route::delete('tasks/{task}/delete_comment/{comment}', 'TaskController@destroyComment')->name('task.destroy_comment');
