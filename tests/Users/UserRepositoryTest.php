<?php

use Laracasts\TestDummy\Factory;
use Blog\Users\User;
use Blog\Users\UserRepository;

class UserRepositoryTest extends TestCase {

    /**
     * Default preparation for each test
     *
     */
    public function setUp()
    {
        parent::setUp(); // Don't forget this!

        $this->prepareForTests();
    }

    public function testSaveUsers()
    {
        $userRepository = new UserRepository(new User());

        $user = Factory::build('Blog\Users\User');

        $user = $userRepository->save($user);

        $this->assertEquals($userRepository->all()[ 0 ]->id, $user->id);
        $this->assertEquals(count($userRepository->all()), 1);

        $user = Factory::build('Blog\Users\User');

        $user = $userRepository->save($user);

        $this->assertEquals(count($userRepository->all()), 2);

    }

    public function testErrorWhenStoringTwoUsersSameEmail()
    {
        /**
         * todo
         */

    }

    public function testSearchUsersByEmail()
    {
        $userRepository = new UserRepository(new User());

        $user = Factory::build('Blog\Users\User');

        $user = $userRepository->save($user);

        $this->assertEquals(count($userRepository->all()), 1);

        $search = $userRepository->search($user->email);

        $this->assertEquals($search->id, $user->id);
    }

}