<?php


namespace Posts;


class PostRepository {

    /**
     * @var Post
     */
    private $post;

    function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->post->all();
    }

    /**
     * @param $id
     * @return Post
     */
    public function find( $id )
    {
        return $this->post->findOrFail($id);
    }

    /**
     * @param string $slug
     * @return Post
     */
    public function searchBySlug( $slug )
    {
        return $this->post->where('slug', $slug)->firstOrFail();

    }

    /**
     * @param Post $post
     * @throws Illuminate\Database\QueryException
     * @return Post|bool
     */
    public function save( Post $post )
    {
        if ( $post->save() )
            return $post;

        return false;
    }

    /**
     * @param Post $post
     * @return bool|null
     * @throws \Exception
     */
    public function destroy( Post $post )
    {
        return $post->delete();
    }
}