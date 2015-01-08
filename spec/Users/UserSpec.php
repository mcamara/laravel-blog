<?php

namespace spec\Blog\Users;

use Blog\Users\User;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserSpec extends ObjectBehavior
{

    function let()
    {
        $this->beConstructedWith([
            'first_name' => 'John',
            'last_name'  => 'Appleseed',
            'email'      => 'john.appleseed@example.com',
            'is_admin'   => false

        ]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Blog\Users\User');
    }

    function it_should_return_full_name()
    {
        $this->fullName->shouldBe('John Appleseed');
    }
}
