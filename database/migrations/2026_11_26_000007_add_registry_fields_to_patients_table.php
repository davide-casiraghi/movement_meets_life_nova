<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Full patient registry: person type, nationality, birth place, VAT data for
 * invoices, contacts, home address, documents and the Sistema TS choice.
 *
 * Encrypted (TEXT): street address, notes, identity card and health card numbers.
 * Clear: what is needed to search, sort or print invoices (city, province, ...).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->string('person_type', 20)->default('individual')->after('id');
            $table->string('first_name')->nullable()->change();
            $table->string('nationality', 2)->default('IT')->after('last_name');
            $table->string('sex', 1)->nullable()->after('nationality');
            $table->string('birth_city')->nullable()->after('birth_date');
            $table->string('birth_province', 2)->nullable()->after('birth_city');
            $table->string('vat_number', 20)->nullable()->after('fiscal_code');
            $table->string('recipient_code', 7)->nullable()->after('vat_number');
            $table->text('notes')->nullable()->after('recipient_code');

            $table->string('mobile', 50)->nullable()->after('email');
            $table->string('pec')->nullable()->after('phone');

            $table->string('address_country', 2)->default('IT')->after('pec');
            $table->string('city')->nullable()->after('address');
            $table->string('province', 2)->nullable()->after('city');
            $table->string('postal_code', 10)->nullable()->after('province');

            $table->text('id_card_number')->nullable()->after('postal_code');
            $table->text('health_card_number')->nullable()->after('id_card_number');
            $table->boolean('ts_transmission')->default(true)->after('health_card_number');
        });
    }

    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn([
                'person_type', 'nationality', 'sex', 'birth_city', 'birth_province', 'vat_number',
                'recipient_code', 'notes', 'mobile', 'pec', 'address_country', 'city', 'province',
                'postal_code', 'id_card_number', 'health_card_number', 'ts_transmission',
            ]);
        });
    }
};
