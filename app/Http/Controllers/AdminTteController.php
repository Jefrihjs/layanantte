<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TteLog;
use App\Exports\TteLogExport;
use Maatwebsite\Excel\Facades\Excel;

class AdminTteController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->year ?? now()->year;

        $query = TteLog::whereYear('tanggal', $year);

        // Filter manual tanggal (jika dipakai)
        if ($request->filled('start') && $request->filled('end')) {
            $query->whereBetween('tanggal', [
                $request->start,
                $request->end
            ]);
        }

        // Filter triwulan
        if ($request->filled('triwulan')) {

            switch ($request->triwulan) {
                case 1:
                    $start = "$year-01-01";
                    $end   = "$year-03-31";
                    break;
                case 2:
                    $start = "$year-04-01";
                    $end   = "$year-06-30";
                    break;
                case 3:
                    $start = "$year-07-01";
                    $end   = "$year-09-30";
                    break;
                case 4:
                    $start = "$year-10-01";
                    $end   = "$year-12-31";
                    break;
            }

            $query->whereBetween('tanggal', [$start, $end]);
        }

        $logs = $query->orderBy('tanggal', 'desc')->paginate(10);

        // Statistik (selalu berdasarkan tahun terpilih)
        $totalTahun = TteLog::whereYear('tanggal', $year)->count();

        $totalBaru = \App\Models\TteLog::whereYear('tanggal', $year)
            ->where('jenis_permohonan', 'baru')
            ->count();

        $totalReset = TteLog::whereYear('tanggal', $year)
            ->where('jenis_permohonan', 'reset_passphrase')
            ->count();

        $totalPerpanjangan = TteLog::whereYear('tanggal', $year)
            ->where('jenis_permohonan', 'perpanjangan')
            ->count();

        return view('admin.index', compact(
            'logs',
            'totalTahun',
            'totalReset',
            'totalPerpanjangan',
            'totalBaru',
            'year'
        ));
    }

    public function show($id)
    {
        $log = \App\Models\TteLog::findOrFail($id);

        // Jika belum diproses, catat admin yang membuka
        if (!$log->diproses_oleh) {
            $log->update([
                'diproses_oleh' => auth()->id(),
                'diproses_pada' => now()
            ]);
        }

        return view('admin.show', compact('log'));
    }

    public function proses($id)
    {
        $log = \App\Models\TteLog::findOrFail($id);

        if ($log->status == 'pending') {
            $log->update([
                'status' => 'diproses',
                'diproses_oleh' => auth()->id(),
                'diproses_pada' => now()
            ]);
        }

        return redirect()
            ->route('admin.permohonan.show', $id)
            ->with('success', 'Permohonan sedang diproses.');
    }

    public function export(Request $request)
    {
        $year = $request->year ?? now()->year;

        return Excel::download(
            new TteLogExport(
                $request->start,
                $request->end,
                $request->triwulan,
                $year
            ),
            'laporan_tte.xlsx'
        );
    }
}
