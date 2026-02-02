<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modifica l'ENUM esistente per aggiungere 'in_arrivo'
        DB::statement("ALTER TABLE vehicles MODIFY COLUMN status ENUM('disponibile', 'in_arrivo', 'venduto', 'archiviato') NOT NULL DEFAULT 'disponibile'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback: rimuove 'in_arrivo' dall'ENUM
        DB::statement("ALTER TABLE vehicles MODIFY COLUMN status ENUM('disponibile', 'venduto', 'archiviato') NOT NULL DEFAULT 'disponibile'");
    }
};