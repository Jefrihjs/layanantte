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
        Schema::table('unit_kerjas', function (Blueprint $table) {
            $table->unique(['nama','kategori']);
        });
    }

    public function down()
    {
        Schema::table('unit_kerjas', function (Blueprint $table) {
            $table->dropUnique(['nama','kategori']);
        });
    }

};
