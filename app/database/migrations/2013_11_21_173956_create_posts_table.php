<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function(Blueprint $table) {
			$table->increments('id');
			foreach (LaravelLocalization::getAllowedLanguages() as $lang) {
				$table->string('title_'.$lang)->nullable()->default(null);
				$table->text('content_'.$lang)->nullable()->default(null);
				$table->text('excerpt_'.$lang)->nullable()->default(null);
			}
			$table->string('slug')->unique()->nullable()->default(null);
			$table->string('image')->nullable()->default(null);
			$table->integer('views')->default(0);
			$table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->on_update('cascade')->on_delete('cascade');
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
		Schema::dropIfExists('posts');
	}

}
