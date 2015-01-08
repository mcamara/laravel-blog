<?php

namespace spec\Blog\Users;

use Blog\Users\User;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserRepositorySpec extends ObjectBehavior {

    function let( User $user )
    {
        $this->beConstructedWith($user);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Blog\Users\UserRepository');
    }
}
