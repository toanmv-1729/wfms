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
    Route::get('/roles/create', 'RoleController@create')->name('roles.create');
    Route::get('/roles/{id}/edit', 'RoleController@edit')->name('roles.edit');
    Route::post('/roles', 'RoleController@store')->name('roles.store');
    Route::put('/roles/{id}', 'RoleController@update')->name('roles.update');
    Route::delete('/roles/{id}', 'RoleController@destroy')->name('roles.destroy');

    Route::resource('staffs', 'StaffController');
    Route::resource('projects', 'ProjectController');
});

Route::group(['middleware' => ['auth']], function() {
    Route::get('/roles', 'RoleController@index')->name('roles.index');

    Route::get('/profile', 'UserController@getProfile')->name('users.profile');
    Route::put('/profile/{id}', 'UserController@updateProfile')->name('users.update.profile');
    Route::post('/update-password', 'UserController@updatePassword')->name('users.update.password');

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/my-projects', 'StaffController@getMyProjects')->name('staffs.my_projects');
    Route::get('/{slug}/overview', 'StaffController@getProjectOverview')->name('staffs.my_projects.overview');

    Route::get('/tickets', 'TicketController@all')->name('tickets.all');
    Route::get('/tickets/{id}', 'TicketController@show')->name('tickets.show');
    Route::get('/tickets/edit/{id}', 'TicketController@edit')->name('tickets.edit');
    Route::post('/tickets/store', 'TicketController@store')->name('tickets.store');
    Route::get('/{slug}/tickets', 'TicketController@index')->name('tickets.index');
    Route::put('/tickets/{id}', 'TicketController@update')->name('tickets.update');
    Route::delete('/tickets/{id}', 'TicketController@destroy')->name('tickets.destroy');
    Route::get('/{slug}/tickets/create', 'TicketController@create')->name('tickets.create');
    Route::post('/tickets/addRelationTicket', 'TicketController@addRelationTicket')->name('tickets.add_relation_ticket');
    Route::get('/{slug}/tickets/{id}/create-sub-ticket', 'TicketController@createSubTicket')->name('tickets.create_sub_ticket');

    Route::post('/teams', 'TeamController@store')->name('teams.store');
    Route::get('{slug}/teams', 'TeamController@index')->name('teams.index');
    Route::put('/teams/{id}', 'TeamController@update')->name('teams.update');
    Route::delete('/teams/{id}', 'TeamController@destroy')->name('teams.destroy');

    Route::post('/versions', 'VersionController@store')->name('versions.store');
    Route::get('{slug}/versions', 'VersionController@index')->name('versions.index');
    Route::put('/versions/{id}', 'VersionController@update')->name('versions.update');
    Route::delete('/versions/{id}', 'VersionController@destroy')->name('versions.destroy');

    Route::post('/documents', 'DocumentController@store')->name('documents.store');
    Route::get('{slug}/documents', 'DocumentController@index')->name('documents.index');
    Route::put('/documents/{id}', 'DocumentController@update')->name('documents.update');
    Route::delete('/documents/{id}', 'DocumentController@destroy')->name('documents.destroy');
    Route::get('{slug}/documents/folder/{uuid}', 'DocumentController@indexChild')->name('documents.child');

    Route::get('/spend-times', 'SpendTimeController@all')->name('spend_times.all');
    Route::get('{slug}/spend-times', 'SpendTimeController@index')->name('spend_times.index');

    Route::post('/sample-descriptions', 'SampleDescriptionController@store')->name('sample_descriptions.store');
    Route::get('{slug}/sample-descriptions', 'SampleDescriptionController@index')->name('sample_descriptions.index');
    Route::put('/sample-descriptions/{id}', 'SampleDescriptionController@update')->name('sample_descriptions.update');
    Route::delete('/sample-descriptions/{id}', 'SampleDescriptionController@destroy')->name('sample_descriptions.destroy');
});
