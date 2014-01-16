<?php

class UserController extends BaseController {

	public function loginForm()
	{
		return View::make('login');
	}

	public function loginPost()
	{
		$validation = Validator::make(Input::all(),User::$validationLogin);
		if($validation->passes())
		{
			$userInfo = [
				"email"		=> Input::get('email'),
				"password"	=> Input::get('password')
			];
		if(Auth::attempt($userInfo,Input::get('remember')))
			{
				Notification::success(Lang::get('messages.logged_in'));
				// Logged in! :)
				return Redirect::route("adminMenu");
			}
			else
			{
				Notification::error(Lang::get('messages.login_wrong_username_password'));
			}
		}
		else
		{
			Notification::error(Lang::get('messages.login_no_username_password'));
		}
		// Redirect to the login form
		return Redirect::route('LoginForm')->withInput(Input::except('password'));
		
	}

	public function logout()
	{
		Auth::logout();
		Notification::success(Lang::get('messages.loggedout'));
		return Redirect::route('LoginForm');
	}

	public function adminMenu()
	{
		$data = [
			'user'	=> Auth::user()
		];
		return View::make('admin/adminMenu', $data);
	}

}