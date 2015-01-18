<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase {

	/**
	 * Creates the application.
	 *
	 * @return \Illuminate\Foundation\Application
	 */
	public function createApplication()
	{
		$app = require __DIR__.'/../bootstrap/app.php';

		$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

		return $app;
	}

	/**
	 * Migrates the database and set the mailer to 'pretend'.
	 * This will cause the tests to run quickly.
	 */
	protected function prepareForTests()
	{
		Artisan::call('migrate');
		Mail::pretend(true);
	}

	protected function mock($class)
	{
		$mock = Mockery::mock($class);
		$this->app->instance($class, $mock);
		return $mock;
	}

}
