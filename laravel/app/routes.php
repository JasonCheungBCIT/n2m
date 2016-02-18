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

Route::get('/', function()
{
	return View::make('hello');
});

Route::resource('users', 'UsersController');

Route::resource('sessions', 'SessionsController');

Route::resource('notes', 'NotesController');

/* ????
Route::delete('delete/{id}', array(
	'uses' => 'UsersController',
	'as' =>
));
*/

Route::get('mynotes', 'NotesController@create');

Route::get('login', 'SessionsController@create');
Route::get('logout', 'SessionsController@destroy');

Route::get('logout', 'SessionsController@destroy');

Route::get('d/{id}', "UsersController@destroy");	// this works

Route::get('deleteMostRecent', function() {
	$user = User::first();
	$user->delete();
	return "Successfully deleted most recent record";
});

// Test route
Route::get('email', function() {
	Mail::send('users/verify', array('firstname'=>'Jay-Dog Cheung'), function($message) {
		$message->to('jayson.cheung@hotmail.com', 'Jason Cheung')->subject('Welcome to n2m');
	});
});

// Debug route
Route::get('register', function() {
	return View::make('users/create');
});

// change this later.
Route::get('register/verify/{confirmationCode}', [
	'as' => 'confirmation_path',
	'uses' => 'UsersController@confirm'
]);

// routes.php
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
