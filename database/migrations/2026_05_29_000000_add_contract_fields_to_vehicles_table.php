<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->string('customer_fiscal_code', 16)->nullable()->after('customer_surname');
            $table->string('customer_birth_place')->nullable()->after('customer_fiscal_code');
            $table->date('customer_birth_date')->nullable()->after('customer_birth_place');
            $table->string('customer_residence_city')->nullable()->after('customer_birth_date');
            $table->string('customer_address')->nullable()->after('customer_residence_city');
            $table->string('customer_street_number', 20)->nullable()->after('customer_address');
            $table->string('customer_email')->nullable()->after('phone_number');
            $table->date('last_revision_date')->nullable()->after('km');
            $table->text('additional_equipment')->nullable()->after('last_revision_date');
        });
    }

    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn([
                'customer_fiscal_code',
                'customer_birth_place',
                'customer_birth_date',
                'customer_residence_city',
                'customer_address',
                'customer_street_number',
                'customer_email',
                'last_revision_date',
                'additional_equipment',
            ]);
        });
    }
};
