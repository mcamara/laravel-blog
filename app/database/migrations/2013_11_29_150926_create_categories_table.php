<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('categories', function(Blueprint $table) {
			$table->increments('id');
			foreach (LaravelLocalization::getAllowedLanguages() as $lang) {
				$table->string('name_'.$lang)->nullable()->default(null);
			}
			$table->string('slug')->unique()->nullable()->default(null);
			$table->integer('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users')->on_update('cascade')->on_delete('cascade');
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
		Schema::dropIfExists('categories');
	}

}