<?php

use Blog\Users\User;
use Blog\Users\UserRepository;
use Blog\Users\Commands\CreateUserCommand;
use Illuminate\Database\QueryException;
use Laracasts\TestDummy\Factory;

class CreateUserCommandTest extends TestCase {

    protected $dispatcher;
    protected $userRepository;
    protected $command;

    public function setUp()
    {
        parent::setUp();
        $this->prepareForTests();
        $this->dispatcher = $this->mock('Illuminate\Contracts\Events\Dispatcher');
        $this->userRepository = new UserRepository(new User());
        $this->command = new CreateUserCommand($this->userRepository, $this->dispatcher);

    }


    public function testSaveUsers()
    {
        $user = Factory::build('Blog\Users\User', [
            'first_name' => 'John',
            'last_name'  => 'Doe'
        ]);

        $this->dispatcher->shouldReceive('fire')->once();
        $this->command->create($user->toArray());

        $this->assertEquals($this->userRepository->all()[ 0 ]->fullName, "John Doe");
        $this->assertEquals(count($this->userRepository->all()), 1);

        $user = Factory::build('Blog\Users\User');
        $this->dispatcher->shouldReceive('fire')->once();
        $this->command->create($user->toArray());
        $this->assertEquals(count($this->userRepository->all()), 2);

        foreach(range(1, 10) as $index)
        {
            $user = Factory::build('Blog\Users\User');
            $this->dispatcher->shouldReceive('fire')->once();
            $this->command->create($user->toArray());
        }
        $this->assertEquals(count($this->userRepository->all()), 12);

    }

    /**
     * @expectedException Illuminate\Database\QueryException
     */
    public function testSaveWithErrorsUsers()
    {
        $user = Factory::build('Blog\Users\User', [
            'first_name' => null,
        ]);

        $this->dispatcher->shouldReceive('fire')->once();
        $this->command->create($user->toArray());
    }

    /**
     * @expectedException Illuminate\Database\QueryException
     */
    public function testTryToStoreTwoUsersWithSameEmail()
    {
        $user = Factory::build('Blog\Users\User', [
            'email' => 'john@example.com',
        ]);

        $this->dispatcher->shouldReceive('fire')->once();
        $this->command->create($user->toArray());

        $this->assertEquals(count($this->userRepository->all()), 1);

        $user = Factory::build('Blog\Users\User', [
            'email' => 'john@example.com',
        ]);

        $this->dispatcher->shouldReceive('fire')->once();
        $this->command->create($user->toArray());
    }
}