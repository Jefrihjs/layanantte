<?php

namespace App\Exports;

use App\Models\TteLog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Events\AfterSheet;

class TteLogExport implements
    FromCollection,
    WithHeadings,
    WithStyles,
    WithEvents,
    ShouldAutoSize,
    WithMapping,
    WithColumnFormatting
{
 protected $data;
 protected $periodeText;

    public function __construct($data, $periodeText)
    {
        $this->data = $data;
        $this->periodeText = $periodeText;
    }

    public function collection()
    {
        return $this->data;
    }

    public function map($log): array
    {
        static $no = 1;

        $jenis = match ($log->jenis_permohonan) {
            'reset_passphrase' => 'Reset Passphrase',
            'perpanjangan'     => 'Perpanjangan Sertifikat',
            'baru'             => 'Pendaftaran Baru',
            default            => $log->jenis_permohonan,
        };

        return [
            $no++,
            $log->tanggal->format('d-m-Y'),
            $log->nama,
            "'" . $log->nik,      // ← INI FIX FINAL
            $log->unit_kerja,
            $jenis,
            $log->keterangan,
        ];
    }


    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Nama',
            'NIK',
            'Unit Kerja',
            'Jenis Permohonan',
            'Keterangan',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_TEXT, // Kolom NIK dipaksa TEXT
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                // Tambah 2 baris untuk judul
                $event->sheet->insertNewRowBefore(1, 2);

                $event->sheet->setCellValue('A1', 'LAPORAN PERMOHONAN LAYANAN TTE');
                $event->sheet->setCellValue('A2', $this->periodeText);

                // Merge cell sesuai jumlah kolom (A–G)
                $event->sheet->mergeCells('A1:G1');
                $event->sheet->mergeCells('A2:G2');

                // Bold + center judul
                $event->sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
                $event->sheet->getStyle('A1:G2')
                    ->getAlignment()
                    ->setHorizontal('center');

                // Center kolom No & Tanggal
                $event->sheet->getStyle('A:A')
                    ->getAlignment()
                    ->setHorizontal('center');

                $event->sheet->getStyle('B:B')
                    ->getAlignment()
                    ->setHorizontal('center');
            },
        ];
    }
}
