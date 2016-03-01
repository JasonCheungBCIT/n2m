<?php

class NotesController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		// Confused on create or show, BECAUSE IT'S BOTH!?
		if (Auth::check()) {

			// Load user information for convenience
			$userData = Auth::user();

			// Load site data
			// Note: ->get() returns an array of objects, the value we want can be accessed by $object->column
			$sites = DB::table('sites')->select('url')->where('user_id', $userData->id)->get();
			// Converting into a usuable string arrray.
			$siteResult = array();
			foreach ($sites as $s) {
				array_push($siteResult, $s->url);
			}

			// Load image data
			$images = DB::table('images')->select('path')->where('user_id', $userData->id)->get();
			$imageResult = array();
			foreach ($images as $i) {
				// Assemble the image
				// $ii = Image::make($i->path);
				// $ii->encode(); // will always render as jpeg.
				array_push($imageResult, $i->path);
			}

			return View::make('users/homepage')
					->with('note', $userData->note)
					->with('todo', $userData->todo)
					->with('image', $userData->image)
					->with('sites', $siteResult)
					->with('images', $imageResult);
			/*
			return Auth::user()->id;
			 Heard something about "flashes data to the session .. can retrieve with Session::get", looks unsecure.
			*/

		} else {
			return Redirect::to('login');
			// Below don't work
			// return redirect()->route('login');
			// return redirect()->action('SessionsController@create'); // login form
		}
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// save information into the database
		$input = Input::all();

		// Update user (1:1 note fields)
		$user = User::find(Auth::user()->id);// maybe auth is declaring (auth) user, and i'm declaring user (model)

		$user->note  = Input::get('note');
		$user->image = Input::get('image');
		$user->todo  = Input::get('todo');

		$user->save();

		// Delete old site entries (haha, easiest way)
		// Note: 2 argument where clause is default to '=' operator
		$oldSites = DB::table('sites')->where('user_id', $user->id)->delete();

		// Update address (1:M fields)
		foreach (Input::get('websites') as $website) {

			// Add in new ones (or maybe not, if you just wanted to delete them)
			$site = new Site;
			$site->user_id = Auth::user()->id;
			$site->url = $website;

			if ($site->isValid()) {
				$site->save();
			} else {
				continue; // Should really display a "not a url" error, but issues with blank boxes.
			}

		}

		// Delete any selected images
		$oldImages = Input::get('delete_image');
		if (isset($oldImages)) {
			foreach ($oldImages as $path) {
				DB::table('images')
					->where('user_id', $user->id)
					->where('path', $path)
					->delete();
			}
		}


		// Update image (1:M but only one upload at a time)
		if (Input::hasFile('user_image')) {
			$imageInstance = Input::file('user_image');
			$userImage = new UserImage;
			$userImage->user_id = Auth::user()->id;
			$userImage->path	= $imageInstance;
			// $userImage->path->move('/public/images/catalog/', 'test.jpg');

			// dd(Input::file('user_image'));
			if ($userImage->isValid()) {

				// create random file name (to avoid collision)
				// Public can't be here or we can't access the image properly
				$rand_path = '/images/' . str_random(20) . '.' . Input::file('user_image')->getClientOriginalExtension();

				// Resize, and save our image
				$imageInstance  = Image::make($imageInstance); // convert into intervention image
				$imageInstance->resize(160, null, function($constraint) {
					$constraint->aspectRatio();		// resize image, bounded by height
				});
				$imageInstance->save("public" . $rand_path);

				// Save the path to the database
				$userImage->path = $rand_path;
				$userImage->save();

			} else {
				dd("failed to upload image");
				// should display a "not a valid image"
			}
		}


		return Redirect::action("NotesController@create");
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		if (Auth::check()) {
			return View::make('users/homepage');
		} else {
			return Redirect::to('login');
			// Below don't work
			// return redirect()->route('login');
			// return redirect()->action('SessionsController@create'); // login form
		}
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
		//
	}


}
