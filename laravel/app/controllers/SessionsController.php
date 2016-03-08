<?php

class SessionsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// The main page for sesions is create (login) - that's the whole point of sessions!
		return Redirect::action('SessionsController@create');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		// opposite of Auth::guest()
		if (Auth::check()) {
			return Redirect::to('mynotes');
		} else {
			return View::make('sessions/create');
		}
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		/* Validate input */
		// Note: No session model
		$rules = [
			'email'    => 'required',	// should change exists:users
			'password' => 'required'
		];

		$input = Input::only('email', 'password');

		$validator = Validator::make($input, $rules);

		if ($validator->fails()) {
			return Redirect::back()->withInput()->withErrors($validator);
		}

		/* Authenticate */
		// Notes: Laravel's Auth::attempt() can take extra conditions such as confirmed == 1 (is user confirmed?)
		$credentials = [
			'email'		=> Input::get('email'),
			'password'	=> Input::get('password'),
			'confirmed' => 1
		];

		if ( !Auth::attempt($credentials) ) {
			// Failed to login
			return Redirect::back()
				->withInput()
				->withErrors([
					'credentials' => "Invalid email-password combination."
				]);
			// We just added our own custom error message by implicitly create a
			// new MessageBag = ['name' => 'message'];
		}


		// Successfully logged in
		return Redirect::to('mynotes');

		// return Redirect::home();
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id = null)
	{
		Auth::logout();
		return Redirect::to('login'); // Ask to login again.
	}


}
