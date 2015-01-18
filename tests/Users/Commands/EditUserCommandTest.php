<?php

use Blog\Users\User;
use Blog\Users\Commands\CreateUserCommand;
use Blog\Users\Commands\EditUserCommand;
use Illuminate\Database\QueryException;

class EditUserCommandTest extends UserTest {

    /**
     * @var Mockery/MockInterface
     */
    protected $dispatcher;

    /**
     * @var EditUserCommand
     */
    protected $command;

    /**
     * @var CreateUserCommand
     */
    protected $createCommand;

    public function setUp()
    {
        parent::setUp();
        $this->prepareForTests();
        $this->dispatcher = $this->mock('Illuminate\Contracts\Events\Dispatcher');
        $this->createCommand = new CreateUserCommand($this->userRepository, $this->dispatcher);
        $this->command = new EditUserCommand($this->userRepository, $this->dispatcher);
    }

    public function testEditUsers()
    {
        $user = $this->createAndSaveUser([
            'first_name' => 'John',
            'last_name'  => 'Doe',
            'email'      => 'one@email.com'
        ]);

        $user = $this->userRepository->search($user->email);
        $data = array_merge($user->toArray(), [
            'email' => 'another@email.com'
        ]);

        $user = $this->command->edit($user->id, $data);
        $this->assertEquals($user->email, 'another@email.com');

        $user = $this->userRepository->find($user->id);
        $this->assertEquals($user->email, 'another@email.com');
    }

    /**
     * @expectedException Illuminate\Database\QueryException
     */
    public function testEditWithErrorsUsers()
    {
        $this->createAndSaveUser([
            'email' => 'one@email.com',
        ]);

        $user = $this->createAndSaveUser([
            'email' => 'two@email.com',
        ]);

        // Try to repeat email
        $data = array_merge($user->toArray(), [
            'email' => 'one@email.com'
        ]);

        $this->command->edit($user->id, $data);

    }

}