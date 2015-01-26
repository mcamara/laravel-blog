<?php


class PostsRepositoryTest extends PostTest {

    public function testAll()
    {

        $this->createAndSavePost();

        $this->assertEquals(1 , count($this->postRepository->all()));
    }

}