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

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

//Route::resource('profiles', 'ProfileController')->middleware('role:admin');
Route::resource('profiles', 'ProfileController');
Route::get('profiles/{id}/enable', 'ProfileController@enable');
Route::get('profiles/{id}/delete', 'ProfileController@destroy');

Route::resource('roles', 'RoleController');
Route::get('roles/{id}/enable', 'RoleController@enable');
Route::get('roles/{id}/delete', 'RoleController@destroy');

Route::resource('profilesroles', 'ProfileRoleController');
Route::get('profilesroles/{id}/delete', 'ProfileRoleController@destroy');

Route::resource('privileges', 'PrivilegeController');
Route::get('privileges/{id}/delete', 'PrivilegeController@destroy');

Route::get('/security', 'SecurityController@index')->name('security');

Route::get('/contact', 'ContactController@contact')->name('contact');
Route::post('/contact', 'ContactController@process_contact')->name('contact');

