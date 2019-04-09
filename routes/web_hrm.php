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
Route::get('/security/authorizeInit', 'SecurityController@authorizeInit')->middleware('checkprivilege:security_authorize')->name('security_authorizeInit');
Route::get('/security/authorizeCallback', 'SecurityController@authorizeCallback')->middleware('checkprivilege:security_authorize')->name('security_authorize');
Route::get('/security/revokeToken', 'SecurityController@revokeToken')->middleware('checkprivilege:security_authorize')->name('security_revokeToken');

Route::get('/contact', 'ContactController@contact')->name('contact');
Route::post('/contact', 'ContactController@process_contact')->name('contact');

Route::get('/administration', 'Administration\AdministrationController@index')->middleware('checkprivilege:administration')->name('administration');

Route::name('administration.')->group(function () {
ReqUtils::routeController('accounts', 'Administration\AccountController', '\App\Model\Administration\Account', ['checkprivilege', 'owner.authorize']);
ReqUtils::routeController('contacts', 'Administration\ContactController', '\App\Model\Administration\Contact', ['checkprivilege', 'owner.authorize']);

Route::post('sellers/interview/add', 'Administration\SellerController@addInterview')->middleware('checkprivilege:sellers_edit')->name('sellers_addTranstion');
Route::post('sellers/interview/remove', 'Administration\SellerController@removeInterview')->middleware('checkprivilege:sellers_edit')->name('sellers_removeTranstion');
Route::post('sellers/interview/load', 'Administration\SellerController@loadInterview')->middleware('checkprivilege:sellers_edit')->name('sellers_loadTranstion');
Route::post('sellers/interview/get', 'Administration\SellerController@getInterviews')->middleware('checkprivilege:sellers_edit')->name('sellers_getTranstions');
Route::match(['get', 'post'], 'sellers/download', 'Administration\SellerController@download')->middleware('checkprivilege:sellers_edit')->name('sellers_download');
Route::post('sellers/removeFile', 'Administration\SellerController@removeFile')->middleware('checkprivilege:sellers_edit')->name('sellers_removeFile');
ReqUtils::routeController('sellers', 'Administration\SellerController', '', ['checkprivilege']);
});

Route::name('main.')->group(function () {
ReqUtils::routeController('categories', 'Gondola\CategoryController', '', ['checkprivilege']);
});