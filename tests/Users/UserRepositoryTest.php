<?php

use Laracasts\TestDummy\Factory;
use Users\User;
use Users\UserRepository;

class UserRepositoryTest extends UserTest {


    public function testSaveUsers()
    {
        $user = $this->createAndSaveUser();

        $this->assertEquals($this->userRepository->all()[ 0 ]->id, $user->id);
        $this->assertEquals(count($this->userRepository->all()), 1);

        $this->createAndSaveUser();

        $this->assertEquals(count($this->userRepository->all()), 2);

    }

    /**
     * @expectedException Illuminate\Database\QueryException
     */
    public function testErrorWhenStoringTwoUsersSameEmail()
    {
        $user = $this->createAndSaveUser([
            'email' => 'example@example.com'
        ]);

        $this->assertEquals($this->userRepository->all()[ 0 ]->id, $user->id);
        $this->assertEquals(count($this->userRepository->all()), 1);


        $this->createAndSaveUser([
            'email' => 'example@example.com'
        ]);
    }

    public function testFindUsers()
    {
        $user = $this->createAndSaveUser();

        $search = $this->userRepository->find($user->id);

        $this->assertEquals($search->first_name, $user->first_name);
        $this->assertEquals(count($this->userRepository->all()), 1);
    }

    /**
     * @expectedException Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function testFindUsersNull()
    {
        $this->userRepository->find(1);
    }

    public function testSearchUsersByEmail()
    {
        $user = $this->createAndSaveUser();

        $search = $this->userRepository->search($user->email);

        $this->assertEquals($search->id, $user->id);
    }

    /**
     * @expectedException Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function testSearchNullUsersByEmail()
    {
        $this->userRepository->search('example@email.com');
    }

    public function testDestroyUsers1()
    {
        $user = $this->createAndSaveUser();

        $this->assertEquals(count($this->userRepository->all()), 1);

        $this->userRepository->destroy($user);
        $this->assertEquals(count($this->userRepository->all()), 0);

        $this->createAndSaveUser();
        $user = $this->createAndSaveUser();
        $this->assertEquals(count($this->userRepository->all()), 2);

        $this->userRepository->destroy($user);
        $this->assertEquals(count($this->userRepository->all()), 1);

    }

    /**
     * @expectedException Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function testDestroyUsers2()
    {
        $user = $this->createAndSaveUser();

        $this->assertEquals(count($this->userRepository->all()), 1);
        $this->assertEquals($user->fullName, $this->userRepository->find($user->id)->fullName);


        $this->userRepository->destroy($user);
        $this->assertEquals(count($this->userRepository->all()), 0);

        $this->userRepository->find($user->id);

    }


}