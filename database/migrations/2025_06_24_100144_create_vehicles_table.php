<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            
            // Dati Principali
            $table->string('brand_model');
            $table->string('license_plate')->unique();
            $table->string('chassis');
            $table->integer('registration_year');
            $table->string('color');
            $table->string('fuel_type');
            $table->boolean('second_key')->default(false);
            $table->string('origin')->nullable();
            $table->boolean('vat_exposed')->default(false);
            $table->date('purchase_date');
            $table->string('registry_number')->unique();
            $table->string('archive_number')->unique()->nullable();
            
            // Costi
            $table->decimal('purchase_price', 10, 2)->default(0);
            $table->decimal('broker', 10, 2)->default(0);
            $table->decimal('transport', 10, 2)->default(0);
            $table->decimal('mechatronics', 10, 2)->default(0);
            $table->decimal('bodywork', 10, 2)->default(0);
            $table->decimal('tire_shop', 10, 2)->default(0);
            $table->decimal('upholstery', 10, 2)->default(0);
            $table->decimal('travel', 10, 2)->default(0);
            $table->decimal('inspection', 10, 2)->default(0);
            $table->decimal('miscellaneous', 10, 2)->default(0);
            $table->decimal('spare_parts', 10, 2)->default(0);
            $table->decimal('washing', 10, 2)->default(0);
            $table->decimal('total_cost', 10, 2)->default(0);
            
            // Dati cliente 
            $table->string('customer_name')->nullable();
            $table->string('customer_surname')->nullable();
            $table->string('payment_method')->nullable();
            $table->json('payment_details')->nullable();
            
            // Stato
            $table->boolean('sold')->default(false);
            $table->boolean('archived')->default(false);
            $table->decimal('sale_price', 10, 2)->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};