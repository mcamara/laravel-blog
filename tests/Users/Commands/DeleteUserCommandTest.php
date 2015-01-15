<?php

use Blog\Users\Commands\DeleteUserCommand;
use Blog\Users\User;
use Blog\Users\UserRepository;
use Blog\Users\Commands\CreateUserCommand;
use Laracasts\TestDummy\Factory;

class DeleteUserCommandTest extends TestCase {


    /**
     * @var Mockery/MockInterface
     */
    protected $dispatcher;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @var DeleteUserCommand
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
        $this->command = new DeleteUserCommand($this->userRepository);
    }


    public function testEditUsers()
    {
        foreach ( range(0, 4) as $index )
        {
            $user = Factory::build('Blog\Users\User', [
                'id' => $index
            ]);

            $this->dispatcher->shouldReceive('fire')->once();
            $this->createCommand->create($user->toArray());
        }

        $this->assertEquals(count($this->userRepository->all()), 5);
        $this->assertTrue($this->command->delete(2));
        $this->assertEquals(count($this->userRepository->all()), 4);

    }

    /**
     * @expectedException Blog\Users\Exceptions\CannotDeleteLastUser
     */
    public function testExceptionWhenDeletingLastUserOfTheSystem()
    {
        $user = Factory::build('Blog\Users\User');

        $this->dispatcher->shouldReceive('fire')->once();
        $user = $this->createCommand->create($user->toArray());

        $this->command->delete($user->id);
    }

}