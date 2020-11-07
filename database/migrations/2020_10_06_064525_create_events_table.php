<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id('id');

            $table->foreignId('event_category_id')->constrained();
            $table->foreignId('event_venue_id')->constrained();
            $table->foreignId('user_id')->constrained();

            $table->string('title');
            $table->text('description');

            $table->string('image')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('website_event_link')->nullable();
            $table->string('facebook_event_link')->nullable();
            $table->string('status')->nullable();

            $table->dateTime('date_start');
            $table->dateTime('date_end');

            $table->string('slug');
            //$table->string('is_published');
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
        Schema::dropIfExists('events');
    }
}
