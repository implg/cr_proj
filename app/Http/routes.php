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
    Route::post('branches/create', ['before' => 'csrf', 'as' => 'create-branch', 'uses' => 'BranchesController@createBranch']);

    // Branch - User
    Route::post('branch-user/update', ['before' => 'csrf', 'as' => 'update-branch-user', 'uses' => 'BranchUserController@updateBranchUser']);

    // Groups
    Route::post('groups-company/create', ['before' => 'csrf', 'as' => 'create-group', 'uses' => 'GroupsController@createGroup']);

    // Company
    Route::resource('company', 'CompanyController');
});
