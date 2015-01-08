<?php

$factory('Blog\Users\User', [
    'first_name' => $faker->firstName,
    'last_name'  => $faker->lastName,
    'email'      => $faker->email,
    'password'   => $faker->password,
    'is_admin'   => rand(0, 1)

]);