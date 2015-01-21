<?php


use Users\Commands\DeleteUserCommand;

class DeleteUserCommandTest extends UserTest {

    private $dispatcher;

    public function setUp()
    {
        parent::setUp();
        $this->dispatcher = $this->mock('Illuminate\Contracts\Events\Dispatcher');
    }

    public function testDeleteUsers()
    {
        foreach ( range(0, 4) as $index )
        {
            $this->createAndSaveUser([
                'id' => $index
            ]);
        }

        $this->assertEquals(count($this->userRepository->all()), 5);

        $command = new DeleteUserCommand(2);
        $command->handle($this->userRepository);
        $this->assertEquals(count($this->userRepository->all()), 4);

        $command = new DeleteUserCommand(1);
        $command->handle($this->userRepository);
        $this->assertEquals(count($this->userRepository->all()), 3);

    }

    /**
     * @expectedException Users\Exceptions\CannotDeleteLastUser
     */
    public function testExceptionWhenDeletingLastUserOfTheSystem()
    {
        $user = $this->createAndSaveUser();
        $command = new DeleteUserCommand($user->id);
        $command->handle($this->userRepository);
    }
}