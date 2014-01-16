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

View::share('categories',Category::all());

Route::group([
		'prefix' => LaravelLocalization::setLanguage(),
		'before' => 'LaravelLocalizationRoutes|LaravelLocalizationRedirectFilter'
	],
	function()
	{
		Route::get("/",["as" => "index", "uses" => "PostController@index"]);
		Route::get(
			LaravelLocalization::transRoute('routes.projects'),
			["as" => "projects", "uses" => "HomeController@showProjects"]
		);
		Route::get(
			LaravelLocalization::transRoute('routes.about'),
			["as" => "about", "uses" => "HomeController@showAbout"]
		);

		Route::get("post/{slug}",["as" => "viewPost", "uses" => "PostController@show"]);

		Route::group(["before"=>"guest"],function()
		{
			Route::get("login",["as" => "LoginForm", "uses" => "UserController@loginForm"]);
			Route::post("login",["before" => "csrf", "as" => "LoginPost", "uses" => "UserController@loginPost"]);
		});
		//admin routes
		Route::group(["before"=>"auth"],function()
		{
			Route::group(["prefix"=>"admin"], function(){
				Route::get("/",["as" => "adminMenu", "uses" => "UserController@adminMenu"]);
				Route::group(["prefix"=>"post"], function(){
					Route::get("/",["as" => "postList", "uses" => "PostController@indexAdmin"]);
					Route::get("create",["as" => "createPost", "uses" => "PostController@create"]);
					Route::get("edit/{id}",["as" => "editPost", "uses" => "PostController@edit"])->where('id', '[0-9]+');
					Route::post("create",["before" => "csrf","as" => "storePost", "uses" => "PostController@store"]);
					Route::post("edit/{id}",["before" => "csrf","as" => "updatePost", "uses" => "PostController@update"])->where('id', '[0-9]+');
					Route::get("delete/{id}",["as" => "deletePost", "uses" => "PostController@destroy"])->where('id', '[0-9]+');
				});
				Route::group(["prefix"=>"category"], function(){
					Route::get("/",["as" => "categoryList", "uses" => "CategoryController@indexAdmin"]);
					Route::get("create",["as" => "createCategory", "uses" => "CategoryController@create"]);
					Route::get("delete/{id}",["as" => "deleteCategory", "uses" => "CategoryController@destroy"])->where('id', '[0-9]+');
				});
			});
			Route::get("logout",["as" => "logout", "uses" => "UserController@logout"]);
		});
	}
);
