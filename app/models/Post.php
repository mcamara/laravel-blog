<?php
	class Post
	extends Eloquent
	{
	    protected $table = "posts";
	    protected $softDelete = true;

	    private $current_locale;

	    public function __construct()
	    {
	    	parent::__construct();
	    	$this->current_locale = App::getLocale();
	    }

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
	    	// $this->translations have always one element at least
	        if(in_array($this->current_locale, $this->translations))
	        {
	        	return $this->{"title_" . $this->current_locale};
	        }
	        return $this->{"title_" . $this->translations[0]};
	    }

	    public function getContentAttribute()
	    {
	        if(in_array($this->current_locale, $this->translations))
	        {
	        	return $this->{"content_" . $this->current_locale};
	        }
	        return $this->{"content_" . $this->translations[0]};

	    }

	    public function getExcerptAttribute()
	    {
	        if(in_array($this->current_locale, $this->translations))
	        {
	        	return $this->{"excerpt_" . $this->current_locale};
	        }
	        return $this->{"excerpt_" . $this->translations[0]};
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