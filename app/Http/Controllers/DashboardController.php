<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TteLog;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->tahun ?? date('Y');

        $baseQuery = TteLog::whereYear('tanggal', $tahun);

        $total = (clone $baseQuery)->count();
        $pendaftaran = (clone $baseQuery)
            ->where('jenis_permohonan', 'baru')
            ->count();

        $reset = (clone $baseQuery)
            ->where('jenis_permohonan', 'reset_passphrase')
            ->count();

        $perpanjangan = (clone $baseQuery)
            ->where('jenis_permohonan', 'perpanjangan')
            ->count();

        // ================= STATUS =================

        $pending = (clone $baseQuery)
            ->where('status', 'pending')
            ->count();

        $diproses = (clone $baseQuery)
            ->where('status', 'diproses')
            ->count();

        $totalStatus = $pending + $diproses;

        $persenSelesai = $totalStatus > 0
            ? round(($diproses / $totalStatus) * 100)
            : 0;

        // ================= RATA-RATA WAKTU =================

        $avgMinutes = (clone $baseQuery)
            ->where('status', 'diproses')
            ->whereNotNull('diproses_pada')
            ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, created_at, diproses_pada)) as avg_minutes')
            ->value('avg_minutes');

        $hari = 0;
        $jam = 0;

        if ($avgMinutes) {
            $hari = floor($avgMinutes / 1440);
            $sisaMenit = $avgMinutes % 1440;
            $jam = floor($sisaMenit / 60);
        }

        $avgFormatted = "{$hari} Hari {$jam} Jam";


        $chartData = [];

        for ($bulan = 1; $bulan <= 12; $bulan++) {

            $pendingBulanan = TteLog::whereYear('tanggal', $tahun)
                ->whereMonth('tanggal', $bulan)
                ->where('status', 'pending')
                ->count();

            $diprosesBulanan = TteLog::whereYear('tanggal', $tahun)
                ->whereMonth('tanggal', $bulan)
                ->where('status', 'diproses')
                ->count();

            $chartData[] = [
                'pending' => $pendingBulanan,
                'diproses' => $diprosesBulanan
            ];
        }


        // Hitung persentase
        $persenBaru = $total > 0 ? round(($pendaftaran / $total) * 100) : 0;
        $persenReset = $total > 0 ? round(($reset / $total) * 100) : 0;
        $persenPerpanjangan = $total > 0 ? round(($perpanjangan / $total) * 100) : 0;
        $latest = TteLog::latest()->take(5)->get();

        return view('dashboard.index', compact(
            'tahun',
            'total',
            'pendaftaran',
            'reset',
            'perpanjangan',
            'chartData',
            'persenBaru',
            'persenReset',
            'persenPerpanjangan',
            'pending',
            'diproses',
            'persenSelesai',
            'avgFormatted',
            'latest'
        ));

    }
}
