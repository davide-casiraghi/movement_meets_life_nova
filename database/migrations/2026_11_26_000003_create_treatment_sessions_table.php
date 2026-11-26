<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Treatment sessions (sedute). Date and duration are in clear for the agenda,
 * every clinical field is encrypted.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('treatment_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->dateTime('performed_at');
            $table->unsignedSmallInteger('duration_minutes')->nullable();

            // Clinical data (encrypted)
            $table->text('pain_before')->nullable();
            $table->text('pain_after')->nullable();
            $table->text('assessment')->nullable();
            $table->text('treatment')->nullable();
            $table->text('home_exercises')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('performed_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('treatment_sessions');
    }
};
