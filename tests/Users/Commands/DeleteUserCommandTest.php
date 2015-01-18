<?php

use Blog\Users\Commands\DeleteUserCommand;
use Blog\Users\User;
use Blog\Users\Commands\CreateUserCommand;
use Laracasts\TestDummy\Factory;

class DeleteUserCommandTest extends UserTest {

    /**
     * @var Mockery/MockInterface
     */
    protected $dispatcher;

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
        $this->createCommand = new CreateUserCommand($this->userRepository, $this->dispatcher);
        $this->command = new DeleteUserCommand($this->userRepository);
    }


    public function testEditUsers()
    {
        foreach ( range(0, 4) as $index )
        {
            $this->createAndSaveUser([
                'id' => $index
            ]);
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
        $user = $this->createAndSaveUser();
        $this->command->delete($user->id);
    }

}