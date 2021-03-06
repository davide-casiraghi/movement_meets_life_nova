<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->string('author')->nullable();
            $table->text('description');
            //$table->boolean('shown')->default(0);
            $table->string('show_where')->nullable();
            $table->boolean('is_published')->default(0);
            $table->dateTime('shown_backend_on')->nullable();
            $table->dateTime('shown_frontend_on')->nullable();

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
        Schema::dropIfExists('quotes');
    }
}
