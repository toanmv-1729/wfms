<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::group(['namespace' => 'Auth'], function() {
    Route::get('/', 'LoginController@index')->name('login.index');
});

Route::group(['middleware' => ['auth', 'isAdmin']], function() {
    Route::get('/companies', 'CompanyController@index')->name('company.index');
    Route::post('/companies', 'CompanyController@store')->name('company.store');
    Route::delete('/companies/{id}', 'CompanyController@destroy')->name('company.destroy');
});

Route::group(['middleware' => ['auth', 'isCompany']], function() {
    Route::resource('staffs', 'StaffController');
    Route::resource('roles', 'RoleController');
    Route::resource('projects', 'ProjectController');
    Route::post('/teams', 'TeamController@store')->name('team.store');
    Route::post('/versions', 'VersionController@store')->name('version.store');
});

Route::group(['middleware' => ['auth']], function() {
    Route::get('/my-projects', 'StaffController@getMyProjects')->name('staffs.my_projects');
    Route::get('/my-projects/{slug}/overview', 'StaffController@getProjectOverview')->name('staffs.my_projects.overview');

    Route::get('/{slug}/tickets/create', 'TicketController@create')->name('tickets.create');
    Route::get('/{slug}/tickets/{id}/create-sub-ticket', 'TicketController@createSubTicket')->name('tickets.create_sub_ticket');
    Route::post('/tickets/store', 'TicketController@store')->name('tickets.store');
    Route::get('/tickets/{id}', 'TicketController@show')->name('tickets.show');
    Route::post('/tickets/addRelationTicket', 'TicketController@addRelationTicket')->name('tickets.add_relation_ticket');
});
