<?php


use Posts\Post;

class PostsRepositoryTest extends PostTest {

    public function testAll()
    {
        $this->createAndSavePost();
        $this->assertEquals(1, count($this->postRepository->all()));

        foreach ( range(0, 10) as $index )
        {
            $this->createAndSavePost();
        }
        $this->assertEquals(12, count($this->postRepository->all()));
    }

    public function testFind()
    {
        $post = $this->createAndSavePost();

        $find = $this->postRepository->find($post->id);
        $this->assertEquals($post->slug, $find->slug);
    }

    /**
     * @expectedException Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function testFindNonExistantPost()
    {
        $this->postRepository->find(1);
    }

    public function testSearchBySlug()
    {
        $post = $this->createAndSavePost([
            'title_en' => 'Example English'
        ]);

        $find = $this->postRepository->searchBySlug("example-english");
        $this->assertEquals($post->id, $find->id);
    }

    /**
     * @expectedException Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function testSearchBySlugNonExistantPost()
    {
        $this->postRepository->searchBySlug("TEST");
    }

    public function testSave()
    {
        $faker = Faker\Factory::create();
        $user = $this->createAndSaveUser();

        $post = new Post();
        $post->title_en = $faker->text(30);
        $post->excerpt_en = $faker->text(100);
        $post->content_en = $faker->text(600);
        $post->title_es = $faker->text(30);
        $post->excerpt_es = $faker->text(100);
        $post->content_es = $faker->text(600);
        $post->views = rand(100, 2130);
        $post->active = 1;
        $post->published_on = $faker->dateTimeBetween('-100 days', '+10 days');
        $post->user_id = $user->id;

        $this->assertNull($post->id);

        $this->postRepository->save($post);

        $this->assertNotNull($post->id);
        $this->assertTrue(is_int($post->id));
    }

    public function testDestroy()
    {
        $post = $this->createAndSavePost();
        $this->assertEquals(1, count($this->postRepository->all()));

        $this->postRepository->destroy($post);

        $this->assertEquals(0, count($this->postRepository->all()));
    }

}