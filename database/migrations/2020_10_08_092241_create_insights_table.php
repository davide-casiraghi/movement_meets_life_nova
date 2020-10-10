<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insights', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('description');

            $table->unsignedBigInteger('post_id')->nullable();

            $table->boolean('is_posted_on_facebook')->default(false);
            $table->boolean('is_posted_on_twitter')->default(false);
            $table->datetime('published_on_facebook_on')->nullable();
            $table->datetime('published_on_twitter_on')->nullable();

            $table->boolean('is_published')->default(false);
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
        Schema::dropIfExists('insights');
    }
}
