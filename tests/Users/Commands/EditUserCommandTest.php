<?php

use Blog\Users\User;
use Blog\Users\UserRepository;
use Blog\Users\Commands\CreateUserCommand;
use Blog\Users\Commands\EditUserCommand;
use Illuminate\Database\QueryException;
use Laracasts\TestDummy\Factory;

class EditUserCommandTest extends TestCase {

    /**
     * @var Mockery/MockInterface
     */
    protected $dispatcher;

    /**
     * @var UserRepository
     */
    protected $userRepository;

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
        $this->userRepository = new UserRepository(new User());
        $this->createCommand = new CreateUserCommand($this->userRepository, $this->dispatcher);
        $this->command = new EditUserCommand($this->userRepository, $this->dispatcher);
    }

    public function testEditUsers()
    {
        $user = Factory::build('Blog\Users\User', [
            'first_name' => 'John',
            'last_name'  => 'Doe',
            'email'      => 'one@email.com'
        ]);

        $this->dispatcher->shouldReceive('fire')->once();
        $this->createCommand->create($user->toArray());

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
        $user = Factory::build('Blog\Users\User', [
            'email' => 'one@email.com',
        ]);
        $this->dispatcher->shouldReceive('fire')->once();
        $this->createCommand->create($user->toArray());

        $user = Factory::build('Blog\Users\User', [
            'email' => 'two@email.com',
        ]);
        $this->dispatcher->shouldReceive('fire')->once();
        $user = $this->createCommand->create($user->toArray());

        // Try to repeat email
        $data = array_merge($user->toArray(), [
            'email' => 'one@email.com'
        ]);

        $user = $this->command->edit($user->id, $data);


    }

}