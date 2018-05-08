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

Route::get('/', 'HomeController@index')->name('main');
Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('profiles', 'ProfileController@index')->middleware('checkprivilege:profiles')->name('profiles.index');
Route::get('profiles/create', 'ProfileController@create')->middleware('checkprivilege:profiles_create')->name('profiles.create');
Route::post('profiles/store', 'ProfileController@store')->middleware('checkprivilege:profiles_create')->name('profiles.store');
Route::put('profiles/{id}', 'ProfileController@update')->middleware('checkprivilege:profiles_edit')->name('profiles.update');
Route::get('profiles/{id}/edit', 'ProfileController@edit')->middleware('checkprivilege:profiles_edit')->name('profiles.edit');
Route::get('profiles/{id}', 'ProfileController@show')->middleware('checkprivilege:profiles_view')->name('profiles.show');
Route::get('profiles/{id}/enable', 'ProfileController@enable')->middleware('checkprivilege:profiles_enable')->name('profiles.enable');
Route::get('profiles/{id}/delete', 'ProfileController@destroy')->middleware('checkprivilege:profiles_remove')->name('profiles.delete');

Route::get('roles', 'RoleController@index')->middleware('checkprivilege:roles')->name('roles.index');
Route::get('roles/create', 'RoleController@create')->middleware('checkprivilege:roles_create')->name('roles.create');
Route::post('roles/store', 'RoleController@store')->middleware('checkprivilege:roles_create')->name('roles.store');
Route::put('roles/{id}', 'RoleController@update')->middleware('checkprivilege:roles_edit')->name('roles.update');
Route::get('roles/{id}/edit', 'RoleController@edit')->middleware('checkprivilege:roles_edit')->name('roles.edit');
Route::get('roles/{id}', 'RoleController@show')->middleware('checkprivilege:roles_view')->name('roles.show');
Route::get('roles/{id}/enable', 'RoleController@enable')->middleware('checkprivilege:roles_enable')->name('roles.enable');
Route::get('roles/{id}/delete', 'RoleController@destroy')->middleware('checkprivilege:roles_remove')->name('roles.delete');

Route::get('profilesroles', 'ProfileRoleController@index')->middleware('checkprivilege:profilesroles')->name('profilesroles.index');
Route::get('profilesroles/create', 'ProfileRoleController@create')->middleware('checkprivilege:profilesroles_create')->name('profilesroles.create');
Route::post('profilesroles/store', 'ProfileRoleController@store')->middleware('checkprivilege:profilesroles_create')->name('profilesroles.store');
Route::get('profilesroles/{id}', 'ProfileRoleController@show')->middleware('checkprivilege:profilesroles_view')->name('profilesroles.show');
Route::get('profilesroles/{id}/delete', 'ProfileRoleController@destroy')->middleware('checkprivilege:profilesroles_remove')->name('profilesroles.delete');

Route::get('privileges', 'PrivilegeController@index')->middleware('checkprivilege:privileges')->name('privileges.index');
Route::get('privileges/create', 'PrivilegeController@create')->middleware('checkprivilege:privileges_create')->name('privileges.create');
Route::post('privileges/store', 'PrivilegeController@store')->middleware('checkprivilege:privileges_create')->name('privileges.store');
Route::get('privileges/{id}', 'PrivilegeController@show')->middleware('checkprivilege:privileges_view')->name('privileges.show');
Route::get('privileges/{id}/delete', 'PrivilegeController@destroy')->middleware('checkprivilege:privileges_remove')->name('privileges.delete');

Route::get('menuitems', 'MenuItemController@index')->middleware('checkprivilege:menuitems')->name('menuitems.index');
Route::get('menuitems/create', 'MenuItemController@create')->middleware('checkprivilege:menuitems_create')->name('menuitems.create');
Route::post('menuitems/store', 'MenuItemController@store')->middleware('checkprivilege:menuitems_create')->name('menuitems.store');
Route::put('menuitems/{id}', 'MenuItemController@update')->middleware('checkprivilege:menuitems_edit')->name('menuitems.update');
Route::get('menuitems/{id}/edit', 'MenuItemController@edit')->middleware('checkprivilege:menuitems_edit')->name('menuitems.edit');
Route::get('menuitems/{id}', 'MenuItemController@show')->middleware('checkprivilege:menuitems_view')->name('menuitems.show');
Route::get('menuitems/{id}/delete', 'MenuItemController@destroy')->middleware('checkprivilege:menuitems_remove')->name('menuitems.delete');


Route::get('users', 'UserController@index')->middleware('checkprivilege:users')->name('users.index');
Route::put('users/{id}', 'UserController@update')->middleware('checkprivilege:users_edit')->name('users.update');
Route::get('users/{id}/edit', 'UserController@edit')->middleware('checkprivilege:users_edit')->name('users.edit');
Route::get('users/{id}', 'UserController@show')->middleware('checkprivilege:users_view')->name('users.show');
Route::get('users/{id}/enable', 'UserController@enable')->middleware('checkprivilege:users_enable')->name('users.enable');
Route::get('users/{id}/delete', 'UserController@destroy')->middleware('checkprivilege:users_remove')->name('users.delete');

Route::get('/security', 'SecurityController@index')->middleware('checkprivilege:security')->name('security');
Route::get('/security/authorizeInit', 'SecurityController@authorizeInit')->middleware('checkprivilege:security_authorize')->name('security_authorizeInit');
Route::get('/security/authorizeCallback', 'SecurityController@authorizeCallback')->middleware('checkprivilege:security_authorize')->name('security_authorize');
Route::get('/security/revokeToken', 'SecurityController@revokeToken')->middleware('checkprivilege:security_authorize')->name('security_revokeToken');

Route::get('/contact', 'ContactController@contact')->name('contact');
Route::post('/contact', 'ContactController@process_contact')->name('contact');

Route::get('/administration', 'Administration\AdministrationController@index')->middleware('checkprivilege:administration')->name('administration');

Route::get('accounts', 'Administration\AccountController@index')->middleware('checkprivilege:accounts')->name('accounts.index');
Route::get('accounts/create', 'Administration\AccountController@create')->middleware('checkprivilege:accounts_create')->name('accounts.create');
Route::post('accounts/store', 'Administration\AccountController@store')->middleware('checkprivilege:accounts_create')->name('accounts.store');
Route::put('accounts/{id}', 'Administration\AccountController@update')->middleware('checkprivilege:accounts_edit')->name('accounts.update');
Route::get('accounts/{id}/edit', 'Administration\AccountController@edit')->middleware('checkprivilege:accounts_edit')->name('accounts.edit');
Route::get('accounts/{id}', 'Administration\AccountController@show')->middleware('checkprivilege:accounts_view')->name('accounts.show');
Route::get('accounts/{id}/enable', 'Administration\AccountController@enable')->middleware('checkprivilege:accounts_enable')->name('accounts.enable');
Route::get('accounts/{id}/delete', 'Administration\AccountController@destroy')->middleware('checkprivilege:accounts_remove')->name('accounts.delete');

