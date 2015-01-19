<?php


use Blog\Users\Controllers\UsersController;

class UsersControllerTest extends UserTest {


    public function setUp()
    {
        parent::setUp();
    }

    public function testStoreUsersFunction()
    {
        $user = $this->createAndSaveUser();
        $request = Blog\Users\Requests\CreateUserRequest::create('/', 'GET', $user->toArray());
        $controller = new UsersController($this->userRepository);
        $controller->store($request);

        $this->assertEquals(count($this->userRepository->all()), 1);

    }
}