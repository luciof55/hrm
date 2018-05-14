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

Route::get('/home', 'HomeController@index')->name('home');

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
Route::get('accounts/{id}/edit', 'Administration\AccountController@edit')->middleware('checkprivilege:accounts_edit')->middleware('owner.authorize:\App\Model\Administration\Account,edit')->name('accounts.edit');
Route::get('accounts/{id}', 'Administration\AccountController@show')->middleware('checkprivilege:accounts_view')->name('accounts.show');
Route::get('accounts/{id}/enable', 'Administration\AccountController@enable')->middleware('checkprivilege:accounts_enable')->middleware('owner.authorize:\App\Model\Administration\Account,enable')->name('accounts.enable');
Route::get('accounts/{id}/delete', 'Administration\AccountController@destroy')->middleware('checkprivilege:accounts_remove')->middleware('owner.authorize:\App\Model\Administration\Account,delete')->name('accounts.delete');

Route::get('contacts', 'Administration\ContactController@index')->middleware('checkprivilege:contacts')->name('contacts.index');
Route::get('contacts/create', 'Administration\ContactController@create')->middleware('checkprivilege:contacts_create')->name('contacts.create');
Route::post('contacts/store', 'Administration\ContactController@store')->middleware('checkprivilege:contacts_create')->name('contacts.store');
Route::put('contacts/{id}', 'Administration\ContactController@update')->middleware('checkprivilege:contacts_edit')->name('contacts.update');
Route::get('contacts/{id}/edit', 'Administration\ContactController@edit')->middleware('checkprivilege:contacts_edit')->middleware('owner.authorize:\App\Model\Administration\Contact,edit')->name('contacts.edit');
Route::get('contacts/{id}', 'Administration\ContactController@show')->middleware('checkprivilege:contacts_view')->name('contacts.show');
Route::get('contacts/{id}/enable', 'Administration\ContactController@enable')->middleware('checkprivilege:contacts_enable')->middleware('owner.authorize:\App\Model\Administration\Contact,enable')->name('contacts.enable');
Route::get('contacts/{id}/delete', 'Administration\ContactController@destroy')->middleware('checkprivilege:contacts_remove')->middleware('owner.authorize:\App\Model\Administration\Contact,delete')->name('contacts.delete');

Route::get('businessrecordstates', 'Administration\BusinessRecordStateController@index')->middleware('checkprivilege:businessrecordstates')->name('businessrecordstates.index');
Route::get('businessrecordstates/create', 'Administration\BusinessRecordStateController@create')->middleware('checkprivilege:businessrecordstates_create')->name('businessrecordstates.create');
Route::post('businessrecordstates/store', 'Administration\BusinessRecordStateController@store')->middleware('checkprivilege:businessrecordstates_create')->name('businessrecordstates.store');
Route::put('businessrecordstates/{id}', 'Administration\BusinessRecordStateController@update')->middleware('checkprivilege:businessrecordstates_edit')->name('businessrecordstates.update');
Route::get('businessrecordstates/{id}/edit', 'Administration\BusinessRecordStateController@edit')->middleware('checkprivilege:businessrecordstates_edit')->middleware('checkprivilege:businessrecordstates_remove')->name('businessrecordstates.edit');
Route::get('businessrecordstates/{id}', 'Administration\BusinessRecordStateController@show')->middleware('checkprivilege:businessrecordstates_view')->name('businessrecordstates.show');
Route::get('businessrecordstates/{id}/enable', 'Administration\BusinessRecordStateController@enable')->middleware('checkprivilege:businessrecordstates_enable')->name('businessrecordstates.enable');
Route::get('businessrecordstates/{id}/delete', 'Administration\BusinessRecordStateController@destroy')->middleware('checkprivilege:businessrecordstates_remove')->name('businessrecordstates.delete');

Route::get('businessrecords', 'Administration\BusinessRecordController@index')->middleware('checkprivilege:businessrecords')->name('businessrecords.index');
Route::get('businessrecords/create', 'Administration\BusinessRecordController@create')->middleware('checkprivilege:businessrecords_create')->name('businessrecords.create');
Route::post('businessrecords/store', 'Administration\BusinessRecordController@store')->middleware('checkprivilege:businessrecords_create')->name('businessrecords.store');
Route::put('businessrecords/{id}', 'Administration\BusinessRecordController@update')->middleware('checkprivilege:businessrecords_edit')->middleware('owner.authorize:\App\Model\Administration\BusinessRecord,update')->name('businessrecords.update');
Route::get('businessrecords/{id}/edit', 'Administration\BusinessRecordController@edit')->middleware('checkprivilege:businessrecords_edit')->middleware('owner.authorize:\App\Model\Administration\BusinessRecord,edit')->middleware('checkprivilege:businessrecords_remove')->name('businessrecords.edit');
Route::get('businessrecords/{id}', 'Administration\BusinessRecordController@show')->middleware('checkprivilege:businessrecords_view')->name('businessrecords.show');
Route::get('businessrecords/{id}/enable', 'Administration\BusinessRecordController@enable')->middleware('checkprivilege:businessrecords_enable')->middleware('owner.authorize:\App\Model\Administration\BusinessRecord,enable')->name('businessrecords.enable');
Route::get('businessrecords/{id}/delete', 'Administration\BusinessRecordController@destroy')->middleware('checkprivilege:businessrecords_remove')->middleware('owner.authorize:\App\Model\Administration\BusinessRecord,delete')->name('businessrecords.delete');