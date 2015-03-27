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

Route::get('/', function() {
    return File::get(public_path() . '/index.html');
});

// API Routes
Route::group(array('prefix' => 'api'), function() {
	Route::resource('confessions', 'ConfessionsController',
		['only' => ['index', 'store']]);
	Route::resource('categories', 'CategoriesController',
		['only' => ['index']]);
});

// Auth Routes
Route::controllers([
	'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

// Admin Routes
Route::controllers([
    'admin/confessions' => 'Admin\ConfessionsAdminController',
    'admin/users' => 'Admin\UsersAdminController',
]);

// Temporarily redirect default admin to confessions dashboard
Route::get('/admin', function() {
    return redirect('admin/confessions');
});
