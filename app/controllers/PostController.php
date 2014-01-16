<?php

class PostController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$data = [
			'posts'			=> Post::orderBy('created_at', 'desc')->paginate(10),
			'locale'		=> App::getLocale()
		];
		return View::make('blog', $data);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function indexAdmin()
	{
		$posts = Post::orderBy('created_at', 'desc')->paginate(10);
		if (Request::ajax())
		{
			foreach ($posts as $post) 
			{
				$post->title = $post->title;
			}
			return $posts->toJson();
		}
		return View::make('admin.indexPost');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$data = [
			'languages'		=> LaravelLocalization::getAllowedLanguages(false),
			'categories'	=> Category::all()
		];
		return View::make('admin.createPost', $data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		$validation = Validator::make(Input::all(),Post::$validation);
		if($validation->passes())
		{
			$post = new Post();
			$languages = array();
			foreach (LaravelLocalization::getAllowedLanguages() as $lang) {
				$post->{"title_$lang"} = Input::get("title_$lang");
				$post->{"content_$lang"} = Input::get("content_$lang");
				if(strlen($post->{"content_$lang"}) > 70)
				{
					$languages[] = $lang;
				}
				if(strlen($post->{"content_$lang"}) > 1000)
				{
					$excerpt = explode("<hr />", $post->{"content_$lang"});
					$excerpt = $excerpt[0];
					if(strlen($excerpt) > 1000)
					{
						$excerpt = explode("\n", wordwrap($excerpt, 1000));
						$excerpt = $excerpt[0] . '...';
					}
				}
				else
				{
					$excerpt = $post->{"content_$lang"};
				}
				$post->{"excerpt_$lang"} = $excerpt;
				if(is_null($post->slug) && strlen($post->{"title_$lang"}))
				{
					$post->setSlugTitle($lang);
				}
			}
			$post->user_id = Auth::user()->id;
			$post->languages = json_encode($languages);
			if(!is_null($post->slug) && $post->save())
			{
				// add image
				$file = Input::file('image');
				if (Input::hasFile('image'))
				{
					$fileName = "post".$post->id.".".$file->getClientOriginalExtension();
					$upload = $file->move(public_path().Config::get('file.uploadPath'), $fileName);
				    if($upload)
				    {
				    	$post->image = Config::get('file.uploadPath').$fileName;
				    	$post->save();
				    }
				    else
				    {
				    	Notification::error(Lang::get('messages.post_error_image'));
				    }
				}
				// add categories
				$categories = array();
				$categories_names = explode(",",Input::get('categories'));
				foreach ($categories_names as $category_name) {
					$cat = Category::where('name_en',$category_name)->first();
					if($cat) $post->categories()->attach($cat->id);
				}
				Notification::success(Lang::get('messages.post_created'));
				return Redirect::route("postList");
			}
			else if (is_null($post->slug)) 
			{
				Notification::error(Lang::get('messages.post_should_have_title'));
			}
			else
			{
				Notification::error(Lang::get('messages.post_error_creating'));
			}
		}
		else
		{
			$messages = $validation->messages()->all();
			foreach ($messages as $message) 
			{
				Notification::error($message);
			}
		}
		return Redirect::route('createPost')->withInput();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  string  $slug
	 * @return Response
	 */
	public function show($slug)
	{
		$post = Post::where('slug',$slug)->get()->first();
        if(!$post)
        {
            App::abort(404);
            return "error";
        }
		$post->newVisit();
		$data = [
			'post' 		=>	$post,	
			'next' 		=>	$post->nextPost(),	
			'prev' 		=>	$post->previousPost(),
			'locale'		=> App::getLocale()
		];
		return View::make('post.view', $data);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//check 404
		$data = [
			'post'			=> Post::find($id),
			'languages'		=> LaravelLocalization::getAllowedLanguages(false),
			'categories'	=> Category::all()
		];
		return View::make('admin.editPost', $data);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$post = Post::find($id);
		$languages = array();
        if(!$post)
        {
            App::abort(404);
            return "error";
        }
		// check user
		foreach (LaravelLocalization::getAllowedLanguages() as $lang) {
			$post->{"title_$lang"} = Input::get("title_$lang");
			$post->{"content_$lang"} = Input::get("content_$lang");
			if(strlen($post->{"content_$lang"}) > 70)
			{
				$languages[] = $lang;
			}
			if(strlen($post->{"content_$lang"}) > 1000)
			{
				$excerpt = explode("<hr />", $post->{"content_$lang"});
				$excerpt = $excerpt[0];
				if(strlen($excerpt) > 1000)
				{
					$excerpt = explode("\n", wordwrap($excerpt, 1000));
					$excerpt = $excerpt[0] . '...';
				}
			}
			else
			{
				$excerpt = $post->{"content_$lang"};
			}
			$post->{"excerpt_$lang"} = $excerpt;
		}
		$post->languages = json_encode($languages);
		if($post->save())
		{
			$categories = array();
			$categories_names = explode(",",Input::get('categories'));
			$categoriesPost = $post->categories;
			foreach ($categoriesPost as $catPost) {
				if(!in_array($catPost->name_en,$categories_names)) 
					$post->categories()->detach($catPost->id);
			}
			foreach ($categories_names as $category_name) {
				$cat = Category::where('name_en',$category_name)->first();
				if($cat)
				{
					$catPost = $post->categories()->where('category_id',$cat->id)->first();
					if(!$catPost) $post->categories()->attach($cat->id);
				} 
			}
			Notification::success(Lang::get('messages.post_edited'));
			return Redirect::route("postList");
		}
		else
		{
			Notification::error(Lang::get('messages.post_error_editing'));
		}
		return Redirect::route('createPost')->withInput(Input::except());
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$post = Post::find($id);
        if(!$post)
        {
            App::abort(404);
            return "error";
        }
		// check user
		if($post->delete())
		{
			Notification::success(Lang::get('messages.post_deleted'));
		}
		else
		{
			Notification::error(Lang::get('messages.post_error_deleting'));
		}
		return Redirect::route("postList");
	}

}