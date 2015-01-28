<?php

use Illuminate\Support\Facades\Auth;

class UsersControllerTest extends UserTest {

    public function setUp()
    {
        parent::setUp();
        $this->auth = new Auth();
    }

    protected function createAndLoginAdmin()
    {
        $user = $this->createAndSaveUser([
            'is_admin' => 1
        ]);
        Auth::loginUsingId($user->id);

        return $user;
    }

    /**
     * @return \Users\User
     */
    public function createAndLoginNonAdminUser()
    {
        $user = $this->createAndSaveUser([
            'is_admin' => 0
        ]);
        Auth::loginUsingId($user->id);

        return $user;
    }

    public function testIndexWithoutLogin()
    {
        $response = $this->action('GET', 'UsersController@index');
        $this->assertRedirectedTo('/');
        $this->assertTrue($response->isRedirection());
    }

    public function testIndexWithoutBeingAdminLogin()
    {
        $this->createAndLoginNonAdminUser();

        $response = $this->action('GET', 'UsersController@index');

        $this->assertRedirectedTo('/');
        $this->assertTrue($response->isRedirection());
    }

    public function testIndexBeingAdminLogin()
    {
        $this->createAndLoginAdmin();

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
        $this->createAndLoginNonAdminUser();
        $response = $this->action('GET', 'UsersController@create');

        $this->assertRedirectedTo('/');
        $this->assertTrue($response->isRedirection());
    }

    public function testCreateBeingAdmin()
    {
        $this->createAndLoginAdmin();

        $this->action('GET', 'UsersController@create');
        $this->assertResponseOk();
    }

    public function testSaveUserBeingAdmin()
    {
        $this->createAndLoginAdmin();

        $faker = Faker\Factory::create();

        $this->action('POST', 'UsersController@store', [ ], [
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


    public function testSavingWithoutBeingAdmin()
    {
        $this->createAndLoginNonAdminUser();

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


    public function testSavingWithoutAllFields()
    {
        $this->createAndLoginAdmin();

        $faker = Faker\Factory::create();

        $this->action('POST', 'UsersController@store', [ ], [
            'first_name' => $faker->firstName,
            'last_name'  => $faker->lastName,
            'email'      => null,
            'password'   => $faker->password,
            'is_admin'   => rand(0, 1),
            '_token'     => csrf_token()
        ]);

        $this->assertResponseStatus(302);
        $this->assertEquals(count($this->userRepository->all()), 1);

    }

    public function testEditFormUserBeingAdmin()
    {
        $user = $this->createAndSaveUser();

        $this->createAndLoginAdmin();

        $response = $this->action('GET', 'UsersController@edit', [ $user->id ]);

        $this->assertViewHas('user');
        $userResponse = $response->original->getData()[ 'user' ];
        $this->assertInstanceOf('Users\User', $userResponse);
        $this->assertEquals($user->fullName, $userResponse->fullName);
    }

    public function testEditFormUserWithoutBeingAdminButBeingTheSameUser()
    {
        $user = $this->createAndLoginNonAdminUser();

        $response = $this->action('GET', 'UsersController@edit', [ $user->id ]);

        $this->assertResponseOk();
        $this->assertViewHas('user');
        $userResponse = $response->original->getData()[ 'user' ];
        $this->assertInstanceOf('Users\User', $userResponse);
        $this->assertEquals($user->fullName, $userResponse->fullName);
    }

    public function testEditFormUserWithoutBeingAdminAndBeingADifferentUser()
    {
        $user = $this->createAndSaveUser([
            'is_admin' => 0
        ]);
        Auth::loginUsingId($user->id);

        $user = $this->createAndSaveUser();
        $this->action('GET', 'UsersController@edit', [ $user->id ]);
        $this->assertResponseStatus(302);
        $this->assertRedirectedTo("/");
    }

    public function testEditFormUserNonExistantUser()
    {
        $this->createAndLoginAdmin();

        $this->action('GET', 'UsersController@edit', [ 1000 ]);
        $this->assertResponseStatus(404);
    }

    public function testUpdateUserBeingAdmin()
    {
        $user = $this->createAndSaveUser();

        $this->createAndLoginAdmin();

        $faker = Faker\Factory::create();

        $this->action('PUT', 'UsersController@update', [ $user->id ], [
            'first_name' => 'John',
            'last_name'  => 'Connor',
            'email'      => 'one@example.com',
            'password'   => $faker->password,
            'is_admin'   => rand(0, 1),
            "_token"     => csrf_token()
        ]);

        $userUpdated = $this->userRepository->search('one@example.com');

        $this->assertEquals($userUpdated->email, 'one@example.com');
        $this->assertEquals($userUpdated->fullName, 'John Connor');

        $this->assertRedirectedToAction('UsersController@show', $userUpdated->id);
    }

    public function testUpdateUserWithoutBeingAdminButBeingTheSameUser()
    {
        $user = $this->createAndLoginNonAdminUser();

        $faker = Faker\Factory::create();

        $this->action('PUT', 'UsersController@update', [ $user->id ], [
            'first_name' => 'John',
            'last_name'  => 'Connor',
            'email'      => 'one@example.com',
            'password'   => $faker->password,
            'is_admin'   => rand(0, 1),
            "_token"     => csrf_token()
        ]);

        $userUpdated = $this->userRepository->search('one@example.com');

        $this->assertEquals($userUpdated->email, 'one@example.com');
        $this->assertEquals($userUpdated->fullName, 'John Connor');

        $this->assertRedirectedToAction('UsersController@show', $userUpdated->id);
    }

    /**
     * @expectedException Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function testUpdateUserWithoutBeingAdminAndADifferentUser()
    {
        $user = $this->createAndSaveUser();

        $this->createAndLoginNonAdminUser();

        $faker = Faker\Factory::create();

        $this->action('PUT', 'UsersController@update', [ $user->id ], [
            'first_name' => 'John',
            'last_name'  => 'Connor',
            'email'      => 'one@example.com',
            'password'   => $faker->password,
            'is_admin'   => rand(0, 1),
            "_token"     => csrf_token()
        ]);

        $this->assertRedirectedTo("/");

        // should raise a ModelNotFoundException
        $this->userRepository->search('one@example.com');
    }

    public function testDeleteUserBeingAdmin()
    {
        $user = $this->createAndSaveUser();
        $this->createAndLoginAdmin();

        $this->action('DELETE', 'UsersController@destroy', [ $user->id ]);

        $this->assertRedirectedToAction('UsersController@index');
        $this->assertEquals(count($this->userRepository->all()), 1);
    }

    public function testDeleteUserWithoutBeingAdminButBeingTheSameUser()
    {
        $user = $this->createAndLoginNonAdminUser();

        $this->action('DELETE', 'UsersController@destroy', [ $user->id ]);

        $this->assertRedirectedTo('/');
        $this->assertEquals(count($this->userRepository->all()), 1);
    }

    public function testDeleteUserWithoutBeingAdminAndADifferentUser()
    {
        $user = $this->createAndSaveUser();

        $this->createAndLoginNonAdminUser();

        $this->action('DELETE', 'UsersController@destroy', [ $user->id ]);

        $this->assertRedirectedTo('');
        $this->assertEquals(count($this->userRepository->all()), 2);
    }


}