<?php

class UsersController extends \BaseController {

	// Dependency injection
	protected $user;
	public function __construct(User $user)
	{
		$this->user = $user;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// The main page of a user is their notes!
		return Redirect::to('mynotes');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('users/create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$siteKey = '6LetOBgTAAAAAIHZSMLj3ytAS7VE-zDSOeDUA1id';
		$secret  = '6LetOBgTAAAAAMhz7pSIorIcNqhGGVJwfvGEUDcM';

		/* Validate valid input */
		$input = Input::all();
		// $this->user->fill($input);

		if ( !($this->user->isValidManual($input)) )  {
			return Redirect::back()->withInput()->withErrors($this->user->messages);
		}

		$recaptcha = new \ReCaptcha\ReCaptcha($secret);
		// $resp = $recaptcha->verify(Input::get('g-recaptcha-response', $_SERVER['REMOTE_ADDR']));
		$resp = $recaptcha->verify(Input::get('g-recaptcha-response'));
		if (!($resp->isSuccess())) {
			echo "<h2>ReCaptcha failure</h2>";
			foreach ($resp->getErrorCodes() as $code) {
				echo '<p>' . $code . '</p>';
			}
			die();
		}

		/* Store into database */
		$confirmation_code = str_random(30);

		/* Create doesn't appear to work
		User::create([
			'email' => Input::get('email'),
			'password' => Hash::make(Input::get('password')),
			'confirmation_code' => $confirmation_code
		]);
		*/

		// Can't use fill b/c of password_confirmation + confirmation_code generation.
        $this->user->email = Input::get('email');
        $this->user->password = Hash::make(Input::get('password'));
        $this->user->confirmation_code = $confirmation_code;
        $this->user->save();

		/* Send confirmation email */
		// todo: do this async
		Mail::send('emails/verify_account', array('confirmation_code'=>$confirmation_code), function($message) {
			$message->to(Input::get('email'), "New user")->subject('Welcome to NotesToMyself');
		});

		return Redirect::to('login'); // Whats this!?
	}

	public function confirm($confirmation_code) {
		/* NOT NEEDED - no arguments = route not usable (qualified)
		// If no confirmation code inputted
		if (!$confirmation_code) {
			return View::make('users/verified')
				->with('message', "<p>Confirmation code invalid.</p>");
		}
		*/

		// Find the first user with the confirmation code
		/*
		 * You can also pass an array - where(['column_name' => $target, 'column_name2' => 'target']);
		 */
		$user = User::whereConfirmationCode($confirmation_code)->first();


		// If no user found
		if (!$user) {
			return View::make('generic')
				->with('title', "Account Verification")
				->with('header', "Invalid Confirmation Code")
				->with('message', "<p>This confirmation code is invalid.</p>");
		}

		// Whoa....
		$user->confirmed = 1;
		$user->confirmation_code = null;
		$user->save();

		return View::make('generic')
			->with('title', "Account Verification")
			->with('header', "Account Verified")
			->with('message', "<p>Thanks for registering, you can now login.</p>
							   <button type='button' onclick=\"window.location='/login'\">Login</button>");
	}

	public function sendPasswordChange() {

		// Validate input
		$v = Validator::make(Input::all(), ['email'=>'required|email']);

		if (!($v->passes())) {
			return Redirect::back()->withInput()->withErrors($v->messages());
		}
		// Find email
		$user = User::whereEmail(Input::get('email'))->first();

		if (!$user) {
			dd("No matching email found. In deployment this won't be shown");
		}

		// Assign a password code (for resetting password)
		$password_code = str_random(30);
		$user->password_code = $password_code;
		$user->save();

		// Send the email
		Mail::send('emails/change_password', array('password_code'=>$password_code), function($message) {
			$message->to(Input::get('email'), "Change password")->subject('Change Notes to Myself password');
		});

		return View::make('generic')
			->with('title', "Password Reset")
			->with('header', "Email Sent")
			->with('message', "<p>A password reset email has been sent to your email.</p>
							   <button type='button' onclick=\"window.location='/login'\">Login</button>");
	}

	public function checkPasswordCode($password_code) {
		// If no confirmation code inputted
		if (!$password_code) {
			dd("No password code detected");
			// throw new InvalidConfirmationCodeException;
		}
		// Find the first user with the password code
		$user = User::wherePasswordCode($password_code)->first();

		// If no user found
		if (!$user) {
			dd("Password code invalid");
			// throw new InvalidConfirmationCodeException;
		}

		return View::make('users/password_change')
			->with('p_code', $password_code);
	}

	public function changePassword() {
		// Validate input
		$v = Validator::make(Input::all(), ['password'=>'required|confirmed|min:6']);
		if (!($v->passes())) {
			return Redirect::back()->withInput()->withErrors($v->messages);
		}

		// Find the first user with the password code
		$user = User::wherePasswordCode(Input::get('p_code'))->first();
		if (!$user) {
			dd("Password code failed .... ? Did you change it manually or was the account deleted?");
		}

		$user->password = Hash::make(Input::get('password'));
		$user->password_code = null;
		$user->save();
		return View::make('generic')
			->with('title', "Password Reset")
			->with('header', "Password Changed")
			->with('message', "<p>Your password has been successfully changed.</p>
							   <button type='button' onclick=\"window.location='/login'\">Login</button>");
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
	public function destroy($id)
	{
		$user = User::find($id);
		$user->delete();
	}


}
