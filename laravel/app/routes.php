<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// Route registering
Route::post('user/send-password-reset', 'UsersController@sendPasswordChange');
Route::post('user/change-password', 	'UsersController@changePassword');
Route::post('user/store', 				'UsersController@store');
Route::post('session/store', 			'SessionsController@store');
Route::post('note/store', 				'NotesController@store');

// User access
Route::get('mynotes', 'NotesController@create');
Route::get('register', 'UsersController@create');
Route::get('login',   'SessionsController@create');
Route::get('logout',  'SessionsController@destroy');

Route::get('forgotPassword', function() {
	return View::make('users/forgot_password');
});

Route::get('/', function() {
	return Redirect::to('mynotes');
});

Route::get('register/verify/{confirmationCode}', [
	'as' => 'confirmation_path',
	'uses' => 'UsersController@confirm'
]);

Route::get('user/check_password_code/{passwordCode}', [
	'as' => 'password_code',
	'uses' => 'UsersController@checkPasswordCode'
]);



/* --- Debug scripts --- */
/*
Route::get('deleteMostRecent', function() {
	$user = User::first();
	$user->delete();
	return "Successfully deleted most recent record";
});
*/


