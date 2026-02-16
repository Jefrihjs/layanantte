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
        Schema::table('tte_logs', function (Blueprint $table) {
            $table->unsignedBigInteger('diproses_oleh')->nullable()->after('keterangan');
            $table->timestamp('diproses_pada')->nullable()->after('diproses_oleh');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tte_logs', function (Blueprint $table) {
            //
        });
    }
};
