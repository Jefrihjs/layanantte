<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tte_logs', function (Blueprint $table) {
            // Menambahkan kolom email setelah no_hp, dan diset nullable (boleh kosong di awal)
            $table->string('email')->nullable()->after('no_hp');
        });
    }

    public function down()
    {
        Schema::table('tte_logs', function (Blueprint $table) {
            $table->dropColumn('email');
        });
    }
};