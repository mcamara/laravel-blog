<?php
	class Post
	extends Eloquent
	{
	    protected $table = "posts";
	    protected $softDelete = true;

		/**
		 * The attributes to validate when a post is created
		 * @var array
		 */
		public static $validation = array(
			"image"		=> 'image|Mimes:jpg,gif,bmp,png,jpeg|max:15360',
		);

	    public function author()
	    {
	    	return $this->belongsTo('User', 'user_id');
	    }

	    public function setSlugTitle($lang = "en")
	    {
	    	$slug = Str::slug($this->{"title_$lang"});
	    	$slugCount = count( $this->whereRaw("slug REGEXP '^{$slug}(-[0-9]*)?$'")->get() );
	    	$slugFinal = ($slugCount > 0) ? "{$slug}-{$slugCount}" : $slug;
	    	$this->slug = $slugFinal;
	    }

	    public function getTitleAttribute()
	    {
	        $locale = App::getLocale();
	        if(!in_array($locale, $this->translations))
	        {
	        	$locale = $this->translations[0];
	        }
	        return $this->{"title_" . $locale};
	    }
	    public function getContentAttribute()
	    {
	        $locale = App::getLocale();
	        if(!in_array($locale, $this->translations))
	        {
	        	$locale = $this->translations[0];
	        }
	        return $this->{"content_" . $locale};

	    }
	    public function getExcerptAttribute()
	    {
	        $locale = App::getLocale();
	        if(!in_array($locale, $this->translations))
	        {
	        	$locale = $this->translations[0];
	        }
	        return $this->{"excerpt_" . $locale};
	    }
	    public function getTranslationsAttribute()
	    {
	        return json_decode($this->languages);
	    }

	    public function newVisit()
	    {
	    	$this->views++;
	    	return $this->save();
	    }

	    public function categories()
	    {
	    	return $this->belongsToMany('Category','category_post','post_id','category_id');
	    }

	    public function nextPost()
	    {
	    	return $this->where('id','>',$this->id)->orderBy('id', 'asc')->first();
	    }
	    public function previousPost()
	    {
	    	return $this->where('id','<',$this->id)->orderBy('id', 'desc')->first();
	    }

	}