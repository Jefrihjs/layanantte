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
        DB::statement("ALTER TABLE tte_logs MODIFY COLUMN jenis_permohonan ENUM('baru', 'reset_passphrase', 'perpanjangan', 'penghapusan', 'lapor_kendala') NOT NULL");
    }

    public function down()
    {
        DB::statement("ALTER TABLE tte_logs MODIFY COLUMN jenis_permohonan ENUM('baru', 'reset_passphrase', 'perpanjangan', 'penghapusan') NOT NULL");
    }

};
