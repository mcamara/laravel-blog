<?php


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
            'is_admin'  => 0
        ]);

        Auth::loginUsingId($user->id);
        $response = $this->action('GET', 'UsersController@index');

        $this->assertRedirectedTo('/');
        $this->assertTrue($response->isRedirection());
    }

    public function testIndexBeingAdminLogin()
    {
        $user = $this->createAndSaveUser([
            'is_admin'  => 1
        ]);
        Auth::loginUsingId($user->id);
        $response = $this->action('GET', 'UsersController@index');

        $this->assertResponseOk();

    }
}