<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddLanguagesToPosts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::table('posts', function(Blueprint $table) {
	      	$table->string('languages',30)->default(json_encode(LaravelLocalization::getAllowedLanguages()));
	    });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	    Schema::table('posts', function(Blueprint $table) {
	        $table->dropColumn('languages');
	    });
	}

}