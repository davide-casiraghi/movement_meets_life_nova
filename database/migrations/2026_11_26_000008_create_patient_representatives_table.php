<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Legal representatives of a patient (parent, guardian, ...), who sign on their behalf.
 * Fiscal code, street address and document number are encrypted.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_representatives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->string('role', 30);
            $table->string('first_name');
            $table->string('last_name');
            $table->text('fiscal_code');
            $table->date('birth_date')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile', 50)->nullable();

            $table->string('country', 2)->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('province', 2)->nullable();
            $table->string('postal_code', 10)->nullable();

            $table->string('document_type', 30)->nullable();
            $table->text('document_number')->nullable();
            $table->string('document_issued_by')->nullable();
            $table->date('document_issued_at')->nullable();
            $table->date('document_expires_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_representatives');
    }
};
