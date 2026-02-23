<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TteLog extends Model
{
    use HasFactory;

    protected $table = 'tte_logs';

    protected $fillable = [
        'tanggal',
        'nama',
        'nik',
        'nip',
        'jabatan',
        'unit_kerja',
        'no_hp',
        'jenis_permohonan',
        'keterangan',
        'status',
        'diproses_oleh',
        'diproses_pada',
    ];

    public function admin()
    {
        return $this->belongsTo(\App\Models\User::class, 'diproses_oleh');
    }

    public function unitKerja()
    {
        return $this->belongsTo(\App\Models\UnitKerja::class, 'unit_kerja', 'nama');
    }

    protected $casts = [
        'tanggal' => 'datetime',
    ];
}
