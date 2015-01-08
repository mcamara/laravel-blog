<?php

namespace spec\Blog\Users\Commands;

use Illuminate\Contracts\Events\Dispatcher;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Blog\Users\UserRepository;
use Blog\Users\User;
use Laracasts\TestDummy\Factory;

class CreateUserCommandSpec extends ObjectBehavior {

    function let( UserRepository $repository, Dispatcher $dispatcher )
    {
        $this->beConstructedWith($repository, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Blog\Users\Commands\CreateUserCommand');
    }

    function it_creates_user_using_the_user_repository( UserRepository $repository )
    {
        $user = Factory::build('Blog\Users\User');

        $this->create($user->toArray());

        $repository
            ->save(new User($user->toArray()))
            ->shouldBeCalled();

    }
}
