<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('users', function(Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->string('username',25)->unique();
			$table->string('email',50)->unique();
    		$table->text('password');
			$table->string('first_name',25);
			$table->string('last_name',25);
			$table->text('description_en');
			$table->text('description_es');
			$table->boolean('status')->default(TRUE);
			$table->softDeletes();
			$table->timestamps();
	    });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
    	Schema::dropIfExists('users');
	}

}