<?php namespace Posts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Posts\Exceptions\PostNeedsAtLeastOneTitle;

class Post extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [ 'password', 'remember_token', 'profile_picture' ];

    public function user()
    {
        $this->belongsTo('Users\User');
    }

    public function getTitleAttribute()
    {
        $attribute = "title_" . app()->getLocale();
        if(!empty($this->attributes[$attribute]))
        {
            return $this->attributes[$attribute];
        }

        $languages = [ 'en', 'es' ];
        // To Be changed when laravel-localization applied

        foreach ( $languages as $language )
        {
            $attribute = "title_" . $language;
            if(!empty($this->attributes[$attribute]))
            {
                return $this->attributes[$attribute];
            }
        }

        throw new PostNeedsAtLeastOneTitle();

    }

    public function setSlugAttribute( $text )
    {
        $this->attributes['slug'] = Str::slug($text);
        $repository = new PostRepository(new Post());

        try
        {
            while ( $post = $repository->searchBySlug($this->slug) )
            {
                if ( $post->id === $this->id )
                {
                    return $post->slug;
                }
                $this->attributes['slug'] = Str::slug($text) . "-" . $number;
                $number++;
            }
        } catch ( ModelNotFoundException $e )
        {
            return $this->slug;
        }
    }

    /**
     * @param array $options
     * @throws PostNeedsAtLeastOneTitle
     * @return bool|void
     */
    public function save( array $options = array() )
    {
        $this->slug = $this->title;

        return parent::save($options);
    }

}