<?php

namespace spec\Blog\Users\Commands;

use Illuminate\Contracts\Events\Dispatcher;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Blog\Users\UserRepository;
use Blog\Users\User;

class CreateUserCommandSpec extends ObjectBehavior {

    function let( UserRepository $repository, Dispatcher $dispatcher )
    {
        $this->beConstructedWith($repository, $dispatcher);
    }

    function it_is_initializable( UserRepository $repository )
    {
        $this->shouldHaveType('Blog\Users\Commands\CreateUserCommand');

        $user = [
            'first_name' => 'John',
            'last_name'  => 'Appleseed',
            'email'      => 'john.appleseed@example.com',
            'is_admin'   => false

        ];

        $this->create($user);

        $repository
            ->save(new User($user))
            ->shouldBeCalled();


    }
}
