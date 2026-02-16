<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tte_logs', function (Blueprint $table) {
            $table->id();

            $table->date('tanggal');

            $table->string('nama');
            $table->string('nik', 16);
            $table->string('nip')->nullable();

            $table->string('jabatan');
            $table->string('unit_kerja');
            $table->string('no_hp');

            $table->enum('jenis_permohonan', [
                'reset_passphrase',
                'perpanjangan'
            ]);

            $table->text('keterangan');

            $table->timestamps();

            $table->index('nik');
            $table->index('tanggal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tte_logs');
    }
};

