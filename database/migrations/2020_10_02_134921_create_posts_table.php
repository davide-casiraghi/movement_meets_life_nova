<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('post_categories');
            $table->string('title');
            $table->integer('created_by')->nullable();
            $table->text('intro_text');
            $table->text('body');
            $table->string('status')->default('2');
            $table->boolean('featured')->default(0);
            $table->text('before_content')->nullable();
            $table->text('after_content')->nullable();
            $table->string('introimage')->nullable();
            $table->string('introimage_alt')->nullable();
            $table->string('slug');
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
