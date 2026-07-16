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
        'bukti_kendala',
        'status',
        'email',
        'diproses_oleh',
        'diproses_pada',
        'bukti_kendala'
    ];

    public function admin()
    {
        return $this->belongsTo(\App\Models\User::class, 'diproses_oleh');
    }

    public function unitKerja()
    {
        return $this->belongsTo(\App\Models\UnitKerja::class, 'unit_kerja', 'nama');
    }

    // === TAMBAHKAN FUNGSI RELASI INI DI BAWAH ===
    /**
     * Relasi ke dirinya sendiri (TteLog) berdasarkan NIK
     * Digunakan untuk mengambil riwayat berapa kali pemohon mengajukan layanan
     */
    public function riwayatPermohonan()
    {
        return $this->hasMany(TteLog::class, 'nik', 'nik');
    }
    // =============================================

    protected $casts = [
        'tanggal' => 'datetime',
    ];
}