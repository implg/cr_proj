<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', ['middleware' => 'sentry.auth', 'as' => 'home', 'uses' => 'MainController@index']);

Route::group(['middleware' => 'sentry.admin'], function() {

    // Branches
    Route::resource('branches', 'BranchesController');

    // Groups
    Route::resource('groups-company', 'GroupsController');

    // Branch - User
    Route::post('branch-user/update', ['before' => 'csrf', 'as' => 'update-branch-user', 'uses' => 'BranchUserController@updateBranchUser']);


});

Route::group(['middleware' => 'sentry.auth'], function() {

    // Company
    Route::resource('company', 'CompanyController');

    // Events
    Route::resource('events', 'EventsController');
    Route::get('events-company/{id}', 'EventsController@getEvents');

    // Tasks
    Route::resource('tasks', 'TasksController');
    Route::get('tasks-datatables', ['before' => 'csrf', 'as' => 'tasks.data', 'uses' => 'TasksController@getData']);

    // Logs
    Route::resource('logs', 'LogsController');
    Route::get('logs-datatables', ['before' => 'csrf', 'as' => 'logs.data', 'uses' => 'LogsController@getData']);
});


