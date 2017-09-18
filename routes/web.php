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

// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
//$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
//$this->post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/version', 'VersionController@index');
Route::post('/version/update', 'VersionController@update');

Route::group(['namespace' => 'Modules', 'prefix' => 'module', 'middleware' => 'auth'], function () {

    // Reverse Engineering File Route
    Route::get('/files/retrieve', 'RetrievesFilesController@index');
    Route::post('/files/retrieve', 'RetrievesFilesController@store');

    // File REST Route
    Route::post('/files/{file}/commit', 'CommitsFileController@commit');
    Route::resource('/files', 'FilesController');

    // File Section Routes
    Route::get('/files/{file}/sections', 'FileSectionsController@index');
    Route::get('/files/{file}/sections/edit', 'FileSectionsController@edit');
    Route::post('/files/{file}/sections', 'FileSectionsController@store');
});

Route::group(['namespace' => 'Files', 'middleware' => 'auth'], function () {

    // Reverse Engineering File Route
    Route::get('/files/retrieve', 'RetrievesFilesController@index');
    Route::post('/files/retrieve', 'RetrievesFilesController@store');

    // File REST Route
    Route::post('/files/{file}/commit', 'CommitsFileController@commit');
    Route::resource('/files', 'FilesController');

    // File Section Routes
    Route::get('/files/{file}/sections', 'FileSectionsController@index');
    Route::get('/files/{file}/sections/edit', 'FileSectionsController@edit');
    Route::post('/files/{file}/sections', 'FileSectionsController@store');
});

Route::get('{any}', 'RedirectsController@index')->where('any', '.*');
