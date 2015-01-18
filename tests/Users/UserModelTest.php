<?php

use Laracasts\TestDummy\Factory;


class UserModelTest extends TestCase {

    public function testFullName()
    {
        $user = Factory::build('Blog\Users\User', [
            'first_name' => 'John',
            'last_name'  => 'Doe'
        ]);

        $this->assertEquals("John Doe", $user->fullName);

    }

}