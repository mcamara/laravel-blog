<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function ( Blueprint $table )
        {
            $table->increments('id');

            $languages = [ 'en', 'es' ];

            foreach ( $languages as $language )
            {
                $table->string('title_' . $language)->nullable();
                $table->text('excerpt_' . $language)->nullable();
                $table->text('content_' . $language)->nullable();
            }

            $table->string('slug', 100)->unique();
            $table->integer('views')->default(0);
            $table->boolean('active')->default(true);
            $table->dateTime('published_on');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::drop('posts');
    }

}
