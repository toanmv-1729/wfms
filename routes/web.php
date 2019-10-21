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

Route::group([ 'middleware' => ['auth']], function() {
    Route::get('/companies', 'CompanyController@index')->name('company.index');
    Route::post('/companies', 'CompanyController@store')->name('company.store');
});
