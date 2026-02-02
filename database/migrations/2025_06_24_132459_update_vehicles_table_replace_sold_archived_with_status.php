<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            // Prima rimuoviamo i campi esistenti
            $table->dropColumn(['sold', 'archived']);
            
            // Poi aggiungiamo status
            $table->enum('status', ['disponibile', 'venduto', 'archiviato'])
                ->default('disponibile');
        });
    }

    public function down()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->boolean('sold')->default(false);
            $table->boolean('archived')->default(false);
        });
    }
};
