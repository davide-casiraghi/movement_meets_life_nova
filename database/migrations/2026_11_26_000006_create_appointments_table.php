<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Calendar events: appointments with patients, holidays and other commitments.
 * starts_at / ends_at are stored in UTC.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('type', 20)->default('work');
            $table->string('status', 20)->default('scheduled');
            $table->foreignId('patient_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('service_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // professional
            $table->string('title');
            $table->decimal('price', 10, 2)->nullable();
            $table->string('color', 7)->nullable();
            $table->dateTime('starts_at');
            $table->dateTime('ends_at');
            $table->string('address')->nullable();
            $table->text('notes')->nullable(); // encrypted
            $table->uuid('recurrence_group')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['starts_at', 'ends_at']);
            $table->index('recurrence_group');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
