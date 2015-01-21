<?php

use Users\Commands\CreateUserCommand;
use Laracasts\TestDummy\Factory;

class CreateUserCommandTest extends UserTest {

    private $dispatcher;

    public function setUp()
    {
        parent::setUp();
        $this->dispatcher = $this->mock('Illuminate\Contracts\Events\Dispatcher');
    }


    public function testSaveUsers()
    {
        $user = Factory::build('Users\User', [
            'first_name' => 'John',
            'last_name'  => 'Doe'
        ]);

        $command = new CreateUserCommand($user->toArray());

        $this->dispatcher->shouldReceive('fire')->once();
        $command->handle($this->userRepository, $this->dispatcher);

        $this->assertEquals($this->userRepository->all()[ 0 ]->fullName, "John Doe");
        $this->assertEquals(count($this->userRepository->all()), 1);

        $user = Factory::build('Users\User');

        $command = new CreateUserCommand($user->toArray());

        $this->dispatcher->shouldReceive('fire')->once();
        $command->handle($this->userRepository, $this->dispatcher);

        $this->assertEquals(count($this->userRepository->all()), 2);

        foreach ( range(1, 10) as $index )
        {
            $user = Factory::build('Users\User');
            $command = new CreateUserCommand($user->toArray());

            $this->dispatcher->shouldReceive('fire')->once();
            $command->handle($this->userRepository, $this->dispatcher);
        }
        $this->assertEquals(count($this->userRepository->all()), 12);

    }

    /**
     * @expectedException Illuminate\Database\QueryException
     */
    public function testSaveWithErrorsUsers()
    {
        $user = Factory::build('Users\User', [
            'first_name' => null,
        ]);

        $command = new CreateUserCommand($user->toArray());

        $this->dispatcher->shouldReceive('fire')->once();
        $command->handle($this->userRepository, $this->dispatcher);

    }

    /**
     * @expectedException Illuminate\Database\QueryException
     */
    public function testTryToStoreTwoUsersWithSameEmail()
    {
        $user = Factory::build('Users\User', [
            'email' => 'john@example.com',
        ]);

        $command = new CreateUserCommand($user->toArray());

        $this->dispatcher->shouldReceive('fire')->once();
        $command->handle($this->userRepository, $this->dispatcher);

        $user = Factory::build('Users\User', [
            'email' => 'john@example.com',
        ]);

        $command = new CreateUserCommand($user->toArray());

        $this->dispatcher->shouldReceive('fire')->once();
        $command->handle($this->userRepository, $this->dispatcher);
    }
}