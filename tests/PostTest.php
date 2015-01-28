<?php


use Laracasts\TestDummy\Factory;
use Posts\Post;
use Posts\PostRepository;
use Users\User;
use Users\UserRepository;

class PostTest extends TestCase {

    /**
     * @var Users\UserRepository
     */
    protected $userRepository;

    /**
     * @var Post\PostRepository
     */
    protected $postRepository;

    /**
     * Default preparation for each test
     *
     */
    public function setUp()
    {
        parent::setUp();
        $this->postRepository = new PostRepository(new Post());
        $this->userRepository = new UserRepository(new User());
    }

    /**
     * @param array $options
     * @return User
     */
    protected function createAndSaveUser( $options = [ ] )
    {
        $user = Factory::build('Users\User', $options);

        return $this->userRepository->save($user);
    }

    /**
     * @param int $user_id
     * @param array $options
     * @return Post
     */
    protected function createAndSavePost( $options = [ ] , $user_id = false )
    {
        if ( !$user_id )
        {
            $user = $this->createAndSaveUser();
            $user_id = $user->id;
        }

        $options[ 'user_id' ] = $user_id;

        $post = Factory::build('Posts\Post', $options);

        return $this->postRepository->save($post);
    }

    public function testSlug()
    {
        $post = $this->createAndSavePost([
            'title_en'  => 'test english'
        ]);

        $this->assertEquals($post->slug, 'test-english');


    }

}