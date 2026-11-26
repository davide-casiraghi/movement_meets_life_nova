<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Invoices issued by the practice (fattura sanitaria / elettronica / nota di credito).
 *
 * An invoice for a patient reveals a treatment, so it is health data: the
 * customer snapshot, the line descriptions, the causals and the notes are encrypted.
 * Amounts stay in clear for the totals of the accounting page.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->restrictOnDelete();
            $table->string('type', 20);
            $table->unsignedSmallInteger('year');
            $table->unsignedInteger('number');
            $table->date('issued_on');
            $table->string('payment_method', 20);
            $table->boolean('paid')->default(false);
            $table->date('paid_on')->nullable();
            $table->date('due_on')->nullable();

            // Customer data as it was when the invoice was issued (encrypted JSON).
            $table->text('customer');

            // Taxation
            $table->string('tax_regime', 4);
            $table->string('pension_fund', 20)->nullable();
            $table->boolean('contribution_enabled')->default(false);
            $table->decimal('contribution_rate', 5, 2)->default(0);
            $table->boolean('contribution_included')->default(false);
            $table->boolean('stamp_enabled')->default(false);
            $table->decimal('stamp_amount', 8, 2)->default(0);
            $table->boolean('stamp_charged_to_issuer')->default(false);
            $table->boolean('stamp_virtual')->default(false);
            $table->boolean('withholding_enabled')->default(false);
            $table->string('withholding_type', 4)->nullable();
            $table->string('withholding_reason', 1)->nullable();
            $table->decimal('withholding_rate', 5, 2)->default(0);
            $table->decimal('withholding_base', 10, 2)->nullable();

            // Bank details printed on the invoice
            $table->string('bank_name')->nullable();
            $table->string('bank_holder')->nullable();
            $table->string('iban', 34)->nullable();
            $table->string('bic', 11)->nullable();

            // Other
            $table->text('causals')->nullable();
            $table->text('central_text')->nullable();
            $table->text('notes')->nullable();

            // Totals, computed by App\Services\Gestionale\InvoiceCalculator
            $table->decimal('taxable_amount', 10, 2)->default(0);
            $table->decimal('contribution_amount', 10, 2)->default(0);
            $table->decimal('vat_amount', 10, 2)->default(0);
            $table->decimal('stamp_charged', 8, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->decimal('withholding_amount', 10, 2)->default(0);
            $table->decimal('net_due', 10, 2)->default(0);

            $table->timestamps();

            $table->unique(['year', 'number']);
            $table->index('issued_on');
        });

        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('position')->default(0);
            $table->foreignId('service_id')->nullable()->constrained()->nullOnDelete();
            $table->text('description');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('quantity', 8, 2)->default(1);
            $table->decimal('discount', 5, 2)->default(0);
            $table->string('vat_code', 5);
            $table->decimal('total', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
        Schema::dropIfExists('invoices');
    }
};
