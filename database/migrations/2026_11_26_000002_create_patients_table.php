<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Patients of the physiotherapy practice.
 *
 * Name, birth date and contacts stay in clear so they can be searched and sorted.
 * Every clinical field (art. 9 GDPR) is a TEXT column holding a value encrypted
 * with the APP_KEY through Laravel's "encrypted" cast.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();

            // Personal data (searchable)
            $table->string('first_name');
            $table->string('last_name');
            $table->date('birth_date')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            // Personal data (encrypted)
            $table->text('fiscal_code')->nullable();
            $table->text('address')->nullable();
            $table->text('occupation')->nullable();

            // Clinical data (encrypted)
            $table->text('current_complaint')->nullable();
            $table->text('medical_history')->nullable();
            $table->text('medications')->nullable();
            $table->text('allergies')->nullable();
            $table->text('clinical_notes')->nullable();

            // GDPR
            $table->timestamp('privacy_notice_signed_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['last_name', 'first_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
