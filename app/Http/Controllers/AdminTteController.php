<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TteLog;
use App\Imports\TteLogImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TteLogExport;
use Carbon\Carbon;

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

        // Filter pencarian
        if ($request->filled('keyword') && $request->filled('field')) {

            $allowedFields = ['nik', 'nama', 'email'];

            if (in_array($request->field, $allowedFields)) {
                $query->where($request->field, 'like', '%' . $request->keyword . '%');
            }
        }

        if ($request->filled('jenis')) {
            $query->where('jenis_permohonan', $request->jenis);
        }
        $logs = $query->orderBy('tanggal', 'desc')
              ->paginate(10)
              ->withQueryString();

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

        return view('admin.permohonan._detail', compact('log'));
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
            ->route('permohonan.show', $id)
            ->with('success', 'Permohonan sedang diproses.');
    }

    public function export(Request $request)
    {
        $year = $request->year ?? now()->year;

        $query = TteLog::whereYear('tanggal', $year);

        $start = null;
        $end   = null;

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

        $data = $query->orderBy('tanggal', 'desc')->get();

        // Buat teks periode
        if ($start && $end) {
            $periodeText = 'Periode: ' .
                \Carbon\Carbon::parse($start)->format('d-m-Y') .
                ' s/d ' .
                \Carbon\Carbon::parse($end)->format('d-m-Y');
        } else {
            $periodeText = "Periode: 01-01-$year s/d 31-12-$year";
        }

        return Excel::download(
            new TteLogExport($data, $periodeText),
            'Laporan_TTE_' . $year . '.xlsx'
        );
    }


    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx'
        ]);

        try {
            // 2. Jalankan proses import
            Excel::import(new TteLogImport, $request->file('file'));
            
            // 3. Jika berhasil, beri notifikasi sukses
            return redirect()->back()->with('success', 'Data berhasil diimport ke sistem!');
            
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            
            // 4. Jika ada error validasi (NIK duplikat/salah), kirim ke 'import_errors'
            return redirect()->back()->with('import_errors', $failures);
            
        } catch (\Exception $e) {
            // 5. Jika ada error sistem lainnya
            return redirect()->back()->withErrors('Gagal import: ' . $e->getMessage());
        }
    }
}
