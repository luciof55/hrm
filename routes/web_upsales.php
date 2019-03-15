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

Route::match(['get', 'post'], '/botman', 'BotManController@handle');
Route::match(['get', 'post'], '/botman/tinker', 'BotManController@tinker');

Route::get('/security/authorizeInit', 'SecurityController@authorizeInit')->middleware('checkprivilege:security_authorize')->name('security_authorizeInit');
Route::get('/security/authorizeCallback', 'SecurityController@authorizeCallback')->middleware('checkprivilege:security_authorize')->name('security_authorize');
Route::get('/security/revokeToken', 'SecurityController@revokeToken')->middleware('checkprivilege:security_authorize')->name('security_revokeToken');

Route::get('/contact', 'ContactController@contact')->name('contact');
Route::post('/contact', 'ContactController@process_contact')->name('contact');

Route::get('/administration', 'Administration\AdministrationController@index')->middleware('checkprivilege:administration')->name('administration');

Route::name('administration.')->group(function () {
ReqUtils::routeController('accounts', 'Administration\AccountController', '\App\Model\Administration\Account', ['checkprivilege', 'owner.authorize']);
ReqUtils::routeController('contacts', 'Administration\ContactController', '\App\Model\Administration\Contact', ['checkprivilege', 'owner.authorize']);
ReqUtils::routeController('businessrecordstates', 'Administration\BusinessRecordStateController', '', ['checkprivilege']);

Route::post('workflows/transition/add', 'Administration\WorkflowController@addTransition')->middleware('checkprivilege:workflows_edit')->name('workflows_addTranstion');
Route::post('workflows/transition/remove', 'Administration\WorkflowController@removeTransition')->middleware('checkprivilege:workflows_edit')->name('workflows_removeTranstion');
Route::post('workflows/transition/get', 'Administration\WorkflowController@getTransitions')->middleware('checkprivilege:workflows_edit')->name('workflows_getTranstions');
ReqUtils::routeController('workflows', 'Administration\WorkflowController', '', ['checkprivilege']);
});

Route::name('main.')->group(function () {

Route::get('home/{id}/excel', 'HomeController@excel')->middleware('checkprivilege:businessrecords_edit')->middleware('owner.authorize:\App\Model\Administration\BusinessRecord,excel')->name('homebusinessrecords.excel');
Route::get('home/{id}/edit', 'HomeController@edit')->middleware('checkprivilege:businessrecords_edit')->middleware('owner.authorize:\App\Model\Administration\BusinessRecord,edit')->name('businessrecords.edit');
Route::put('home/{id}', 'HomeController@update')->middleware('checkprivilege:businessrecords_edit')->middleware('owner.authorize:\App\Model\Administration\BusinessRecord,update')->name('businessrecords.update');

Route::get('businessrecords/{id}/excel', 'Administration\BusinessRecordController@excel')->middleware('checkprivilege:businessrecords_edit')->middleware('owner.authorize:\App\Model\Administration\BusinessRecord,excel')->name('businessrecords.excel');
ReqUtils::routeController('businessrecords', 'Administration\BusinessRecordController', '\App\Model\Administration\BusinessRecord', ['checkprivilege', 'owner.authorize']);

ReqUtils::routeController('categories', 'Gondola\CategoryController', '', ['checkprivilege']);
});