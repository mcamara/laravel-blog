<?php
	class Category
	extends Eloquent
	{
	    protected $table = "categories";

	    public function user()
	    {
	    	return $this->belongsTo('User');
	    }

	    public function setSlugTitle($lang = "en")
	    {
	    	$slug = Str::slug($this->{"title_$lang"});
	    	$slugCount = count( $this->whereRaw("slug REGEXP '^{$slug}(-[0-9]*)?$'")->get() );
	    	$slugFinal = ($slugCount > 0) ? "{$slug}-{$slugCount}" : $slug;
	    	$this->slug = $slugFinal;
	    }

	    public function getNameAttribute()
	    {
	        $locale = App::getLocale();
	        $column = "name_" . $locale;
	        return $this->{$column};
	    }

	    public function posts()
	    {
	    	return $this->belongsToMany('Post','category_post','category_id','post_id');
	    }
	}