<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function index()
	{
		$data = [
			'user'			=> Auth::user(),
			'posts'			=> Post::orderBy('created_at', 'desc')->paginate(2)
		];
		return View::make('blog', $data);
	}

	public function showProjects()
	{
		return View::make('projects');
	}

	public function showAbout()
	{
		return View::make('about');
	}

}