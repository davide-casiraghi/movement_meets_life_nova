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

            $table->string('title');
            $table->text('body')->nullable();
            $table->string('introimage')->nullable();
            $table->string('introimage_alt')->nullable();
            $table->string('slug');

            $table->text('facebook_body')->nullable();
            $table->text('twitter_body')->nullable();
            $table->text('instagram_body')->nullable();

            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('instagram_url')->nullable();


            $table->datetime('published_on_facebook_on')->nullable();
            $table->datetime('published_on_twitter_on')->nullable();
            $table->datetime('published_on_instagram_on')->nullable();

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
