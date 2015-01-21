<?php

use Users\Controllers\UsersController;
use Users\Requests\CreateUserRequest;
use Faker\Factory as Faker;

class UsersControllerTest extends UserTest {


    public function setUp()
    {
        parent::setUp();
        $this->userRepository = $this->mock('Users\UserRepository');
    }

    public function testStoreUsersFunction()
    {
        $faker = Faker::create();
        $request = CreateUserRequest::create('/', 'POST', [
            'first_name' => $faker->firstName,
            'last_name'  => $faker->lastName,
            'email'      => $faker->email,
            'password'   => $faker->password,
            'is_admin'   => rand(0, 1)

        ]);

        $controller = new UsersController($this->userRepository);

        $this->userRepository
            ->shouldReceive('save')
            ->once();

        Event::shouldReceive('fire')->once();
        $controller->store($request);

    }
}