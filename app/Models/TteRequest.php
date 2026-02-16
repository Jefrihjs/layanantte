<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TteRequest extends Model
{
    use HasFactory;

    protected $table = 'tte_requests';

    protected $fillable = [
        'ticket_number',
        'jenis_identitas',
        'nomor_identitas',
        'nama',
        'jabatan',
        'unit_kerja',
        'email',
        'jenis_layanan',
        'status',
        'keterangan',
        'processed_by',
        'ip_address',
    ];

    /**
     * Relasi ke verifikator (users table)
     */
    public function processor()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
}
