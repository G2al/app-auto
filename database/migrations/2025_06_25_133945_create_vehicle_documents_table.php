<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
            $table->enum('category', ['libretto', 'riparazione', 'atto_vendita', 'contratto']);
            $table->string('filename');
            $table->string('original_name');
            $table->string('file_path');
            $table->enum('file_type', ['image', 'pdf']);
            $table->string('mime_type');
            $table->unsignedBigInteger('file_size');
            $table->boolean('is_auto_generated')->default(false);
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_documents');
    }
};