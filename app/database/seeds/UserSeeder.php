<?php

class UserSeeder extends DatabaseSeeder
{
	public function run()
	{
		$users = array(
			array(
				'username'		=> 'admin',
				'email'			=> 'admin@gmail.com',
				'password'		=> Hash::make("test"),
				'first_name'	=> 'Admin',
				'last_name'		=> 'Admin',
				'description_es'=> 'Admin',
				'description_en'=> 'Admin',
			),
		);

		foreach ($users as $user) {
			User::create($user);
		}
	}
}