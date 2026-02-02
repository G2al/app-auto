<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('vehicle_documents', function (Blueprint $table) {
            $table->string('file_type', 10)->change(); // Aumenta da 2 a 10 caratteri
        });
    }

    public function down()
    {
        Schema::table('vehicle_documents', function (Blueprint $table) {
            $table->string('file_type', 2)->change(); // Torna alla lunghezza originale
        });
    }
};