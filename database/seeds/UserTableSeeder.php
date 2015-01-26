<?php

use Illuminate\Database\Seeder;
use Users\User;
use Users\UserRepository;

class UserTableSeeder extends Seeder {

    /**
     * @var UserRepository
     */
    private $repository;

    function __construct( UserRepository $repository )
    {
        $this->repository = $repository;
    }

    public function run()
    {
        $faker = Faker\Factory::create();

        for ( $i = 0; $i < 10; $i++ )
        {
            $this->repository->save(new User([
                'first_name' => $faker->firstName,
                'last_name'  => $faker->lastName,
                'email'      => $faker->email,
                'password'   => str_random(10),
                'is_admin'   => rand(0, 1)
            ]));
        }
    }
}