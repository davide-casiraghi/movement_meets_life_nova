<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Price list of the practice. A service is archived, never deleted, so that
 * appointments and invoices that used it keep pointing to it.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 50)->nullable();
            $table->string('color', 7)->nullable();
            $table->text('description')->nullable();
            $table->unsignedSmallInteger('duration_minutes')->nullable();
            $table->string('vat_code', 8);
            $table->decimal('price', 10, 2);
            $table->timestamp('archived_at')->nullable();
            $table->timestamps();

            $table->index('archived_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
