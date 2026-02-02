<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->decimal('passaggio', 10, 2)->default(0)->nullable()->after('washing');
            $table->decimal('accessori', 10, 2)->default(0)->nullable()->after('passaggio');
        });
    }

    public function down()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn(['passaggio', 'accessori']);
        });
    }
};