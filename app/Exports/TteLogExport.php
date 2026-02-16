<?php

namespace App\Exports;

use App\Models\TteLog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;

class TteLogExport implements FromCollection, WithHeadings, WithStyles, WithEvents, ShouldAutoSize
{
    protected $start;
    protected $end;

    public function __construct($start = null, $end = null)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function collection()
    {
        $query = TteLog::query();

        if ($this->start && $this->end) {
            $query->whereBetween('tanggal', [
                $this->start,
                $this->end
            ]);
        }

        $logs = $query->orderBy('tanggal', 'asc')->get();

        return $logs->values()->map(function ($log, $index) {
            return [
                $index + 1,
                $log->tanggal->format('d-m-Y'),
                $log->nama,
                $log->jenis_permohonan === 'reset_passphrase'
                    ? 'Reset Passphrase'
                    : 'Perpanjangan Sertifikat',
                $log->keterangan,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Nama',
            'Jenis Permohonan',
            'Keterangan',
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

                // Judul laporan
                $event->sheet->insertNewRowBefore(1, 2);
                $event->sheet->setCellValue('A1', 'LAPORAN PERMOHONAN LAYANAN TTE');

                if ($this->start && $this->end) {
                    $event->sheet->setCellValue('A2', 
                        'Periode: ' . date('d-m-Y', strtotime($this->start)) .
                        ' s/d ' . date('d-m-Y', strtotime($this->end))
                    );
                } else {
                    $event->sheet->setCellValue('A2', 'Semua Data');
                }

                // Merge judul
                $event->sheet->mergeCells('A1:E1');
                $event->sheet->mergeCells('A2:E2');

                // Bold judul
                $event->sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

                // Center kolom No & Tanggal
                $event->sheet->getStyle('A:A')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('B:B')->getAlignment()->setHorizontal('center');
            },
        ];
    }
}
