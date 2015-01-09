<?php

namespace spec\Blog\Users;

use Blog\Users\User;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Laracasts\TestDummy\Factory;


class UserRepositorySpec extends ObjectBehavior {

    function let( User $user )
    {
        $this->beConstructedWith($user);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Blog\Users\UserRepository');
    }

    function it_should_save_users()
    {
        $user = Factory::build('Blog\Users\User');

        $this->save($user);

//        $this->all()[0]->shouldBe($user);
    }
}
