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

Route::resource('users', 'UsersController');
Route::resource('sessions', 'SessionsController');
Route::resource('notes', 'NotesController');
Route::post('sendPwEmail', 'UsersController@sendPasswordChange');
Route::post('changePw', 'UsersController@changePassword');

Route::get('mynotes', 'NotesController@create');
Route::get('login',   'SessionsController@create');
Route::get('logout',  'SessionsController@destroy');

Route::get('/', function() {
	return Redirect::to('mynotes');
});

Route::get('register', function() {
	return View::make('users/create');
});

// change this later.
Route::get('register/verify/{confirmationCode}', [
	'as' => 'confirmation_path',
	'uses' => 'UsersController@confirm'
]);

Route::get('forgotPassword', function() {
	return View::make('users/forgotPassword');
});

Route::get('user/check_password_code/{passwordCode}', [
	'as' => 'password_code',
	'uses' => 'UsersController@checkPasswordCode'
]);



/* --- Debug scripts --- */
Route::get('d/{id}', "UsersController@destroy");	// this works

Route::get('deleteMostRecent', function() {
	$user = User::first();
	$user->delete();
	return "Successfully deleted most recent record";
});

Route::get('test_email', function() {
	Mail::send('Content', array('firstname'=>'Jason', 'lastname'=>'Cheung', function($message) {
		$message->to('jayson.cheung@hotmail.com', 'Jason Cheung')->subject('Testing email');
	}));
});

Route::get("testdb", function()
{

	$users = User::all();

	return View::make("testdb")->with("allUsers", $users);

});

Route::get('deleteLastImage', function() {
	$img = UserImage::first();
	$img->delete();
	return "deleted image";
});

Route::get('testimage', function() {
	$img = Image::make('public/second.jpg');
	// $rand_path =  base_path() . '/public/images/test/' . str_random(20) . '.' . Input::file('user_image')->getClientOriginalExtension();
	$path = base_path() . '/public/images/';

	// resize the image to a width of 300 and constrain aspect ratio (auto height)
	// BIND BY WIDTH, CALCULATE HEIGHT FOR ME.
	$img->resize(100, null, function ($constraint) {
		$constraint->aspectRatio();
	})->save($path . "4.jpg");;

	// resize the image to a height of 200 and constrain aspect ratio (auto width)
	$img->resize(null, 200, function ($constraint) {
		$constraint->aspectRatio();
	})->save($path . "5.jpg");;

	// prevent possible upsizing
	$img->resize(null, 400, function ($constraint) {
		$constraint->aspectRatio();
		$constraint->upsize();
	})->save($path . "6.jpg");;

	return $img->response();
		//$img->response();
});

