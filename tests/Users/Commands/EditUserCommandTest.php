<?php


use Users\Commands\EditUserCommand;

class EditUserCommandTest extends UserTest {

    private $dispatcher;

    public function setUp()
    {
        parent::setUp();
        $this->dispatcher = $this->mock('Illuminate\Contracts\Events\Dispatcher');
    }

    public function testEditUsers()
    {
        $user = $this->createAndSaveUser([
            'first_name' => 'John',
            'last_name'  => 'Doe',
            'email'      => 'one@email.com'
        ]);

        $user = $this->userRepository->search($user->email);
        $this->assertEquals($user->email, 'one@email.com');

        $data = array_merge($user->toArray(), [
            'email' => 'another@email.com'
        ]);

        $command = new EditUserCommand($user->id, $data);
        $this->dispatcher->shouldReceive('fire')->once();
        $command->handle($this->userRepository, $this->dispatcher);

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

        $command = new EditUserCommand($user->id, $data);
        $this->dispatcher->shouldReceive('fire')->once();
        $command->handle($this->userRepository, $this->dispatcher);
    }

}