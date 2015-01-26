<?php

$factory('Users\User', [
    'first_name' => $faker->firstName,
    'last_name'  => $faker->lastName,
    'email'      => $faker->email,
    'password'   => $faker->password,
    'is_admin'   => rand(0, 1)

]);

$factory('Posts\Post', [
    'title_en' => $faker->text(30),
    'excerpt_en'  => $faker->text(100),
    'content_en'   => $faker->text(600),
    'title_es' => $faker->text(30),
    'excerpt_es'  => $faker->text(100),
    'content_es'   => $faker->text(600),
    'slug' => $faker->slug,
    'views' => rand(100, 2130),
    'active' => 1,
    'published_on' => $faker->dateTimeBetween('-100 days', '+10 days')

]);