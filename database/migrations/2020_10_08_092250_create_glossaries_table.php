<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGlossariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('glossaries', function (Blueprint $table) {
            $table->id();
            $table->string('term')->nullable();
            $table->text('definition');
            $table->text('body');
            $table->string('introimage')->nullable();
            $table->string('introimage_alt')->nullable();
            $table->integer('question_type')->nullable();
            $table->boolean('is_published')->default(0);

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
        Schema::dropIfExists('glossaries');
    }
}
