<?php

namespace App\Imports;

use App\Models\TteLog;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class TteLogImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        // Parsing Tanggal dari format Custom Excel Anda
        $tanggalRaw = $row['tanggal'];
        $tanggalFix = null;

        try {
            if (is_numeric($tanggalRaw)) {
                $tanggalFix = Carbon::instance(Date::excelToDateTimeObject($tanggalRaw));
            } else {
                // Sesuai format di screenshot: dd/mm/yyyy hh:mm:ss
                $tanggalFix = Carbon::createFromFormat('d/m/Y H:i:s', trim($tanggalRaw));
            }
        } catch (\Exception $e) {
            $tanggalFix = now(); 
        }

        return new TteLog([
            'tanggal'          => $tanggalFix,
            'nama'             => ucwords(strtolower(trim($row['nama']))),
            'jabatan'          => $row['jabatan'],
            'unit_kerja'       => $row['unit_kerja'],
            'no_hp'            => preg_replace('/[^0-9]/', '', $row['no_hp']),
            'jenis_permohonan' => 'baru',
            'nik'              => (string)$row['nik'],
            'nip'              => preg_replace('/\s+/', '', $row['nip']),
            'keterangan'       => 'Registrasi SE baru untuk TTE',
            'status'           => 'pending'
        ]);
    }

    public function uniqueBy()
    {
        return 'nik';
    }
    
    public function rules(): array
    {
        return [
            'nik' => 'required|digits:16|unique:tte_logs,nik',
            'nama' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nik.unique' => 'NIK :input sudah ada di database.',
            'nik.digits' => 'NIK harus 16 digit.',
        ];
    }
}