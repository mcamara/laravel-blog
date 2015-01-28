<?php

use Users\User;
use Users\UserRepository;
use Laracasts\TestDummy\Factory;

class UserTest extends TestCase {

    /**
     * @var Users\UserRepository
     */
    protected $userRepository;

    /**
     * Default preparation for each test
     */
    public function setUp()
    {
        parent::setUp();
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

    public function testFullName()
    {
        $user = Factory::build('Users\User', [
            'first_name' => 'John',
            'last_name'  => 'Doe'
        ]);

        $this->assertEquals("John Doe", $user->fullName);

    }
}