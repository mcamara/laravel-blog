<?php

use Illuminate\Support\Facades\Auth;

class UsersControllerTest extends UserTest {

    public function setUp()
    {
        parent::setUp();
        $this->auth = new Auth();
    }

    public function testIndexWithoutLogin()
    {
        $response = $this->action('GET', 'UsersController@index');
        $this->assertRedirectedTo('/');
        $this->assertTrue($response->isRedirection());
    }

    public function testIndexWithoutBeingAdminLogin()
    {
        $user = $this->createAndSaveUser([
            'is_admin' => 0
        ]);

        Auth::loginUsingId($user->id);
        $response = $this->action('GET', 'UsersController@index');

        $this->assertRedirectedTo('/');
        $this->assertTrue($response->isRedirection());
    }

    public function testIndexBeingAdminLogin()
    {
        $user = $this->createAndSaveUser([
            'is_admin' => 1
        ]);
        Auth::loginUsingId($user->id);

        $response = $this->action('GET', 'UsersController@index');
        $this->assertResponseOk();

        $this->assertViewHas('users');
        $users = $response->original->getData()[ 'users' ];
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $users);
    }

    public function testShowUser()
    {
        $user = $this->createAndSaveUser();
        $response = $this->action('GET', 'UsersController@show', [ $user->id ]);
        $this->assertResponseOk();

        $this->assertViewHas('user');
        $userResponse = $response->original->getData()[ 'user' ];
        $this->assertInstanceOf('Users\User', $userResponse);
        $this->assertEquals($user->fullName, $userResponse->fullName);
    }


    public function testErrorShowingNonExistantUser()
    {
        $this->action('GET', 'UsersController@show', [ 1000 ]);
        // Change Kernel file to handle this exception
        $this->assertResponseStatus(404);
    }

    public function testCreateUserWithoutBeingAdmin()
    {
        $user = $this->createAndSaveUser([
            'is_admin' => 0
        ]);

        Auth::loginUsingId($user->id);
        $response = $this->action('GET', 'UsersController@create');

        $this->assertRedirectedTo('/');
        $this->assertTrue($response->isRedirection());
    }

    public function testCreateBeingAdmin()
    {
        $user = $this->createAndSaveUser([
            'is_admin' => 1
        ]);
        Auth::loginUsingId($user->id);

        $this->action('GET', 'UsersController@create');
        $this->assertResponseOk();
    }

    public function testSaveUserBeingAdmin()
    {
        $user = $this->createAndSaveUser([
            'is_admin' => 1
        ]);
        Auth::loginUsingId($user->id);

        $faker = Faker\Factory::create();

        $response = $this->action('POST', 'UsersController@store', [ ], [
            'first_name' => $faker->firstName,
            'last_name'  => $faker->lastName,
            'email'      => 'email@example.com',
            'password'   => $faker->password,
            'is_admin'   => rand(0, 1),
            "_token"     => csrf_token()
        ]);

        $userCreated = $this->userRepository->search('email@example.com');

        $this->assertEquals($userCreated->email, 'email@example.com');
        $this->assertEquals(count($this->userRepository->all()), 2);

        $this->assertRedirectedToAction('UsersController@show', $userCreated->id);

    }

    /**
     * @expectedException Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function testSavingWithoutBeingAdmin()
    {
        $user = $this->createAndSaveUser([
            'is_admin' => 0
        ]);
        Auth::loginUsingId($user->id);

        $faker = Faker\Factory::create();

        $this->action('POST', 'UsersController@store', [ ], [
            'first_name' => $faker->firstName,
            'last_name'  => $faker->lastName,
            'email'      => 'email@example.com',
            'password'   => $faker->password,
            'is_admin'   => rand(0, 1),
            '_token'     => csrf_token()
        ]);

        $this->assertRedirectedTo('/');
        $this->assertEquals(count($this->userRepository->all()), 1);

    }

}