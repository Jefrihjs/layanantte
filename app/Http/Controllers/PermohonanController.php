<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TteLog;

class PermohonanController extends Controller
{
    public function index(Request $request)
    {
        $query = TteLog::query();

        if ($request->tahun) {
            $query->whereYear('tanggal', $request->tahun);
        }

        if ($request->triwulan && $request->tahun) {

            switch ($request->triwulan) {
                case 1:
                    $start = $request->tahun . '-01-01';
                    $end   = $request->tahun . '-03-31';
                    break;
                case 2:
                    $start = $request->tahun . '-04-01';
                    $end   = $request->tahun . '-06-30';
                    break;
                case 3:
                    $start = $request->tahun . '-07-01';
                    $end   = $request->tahun . '-09-30';
                    break;
                case 4:
                    $start = $request->tahun . '-10-01';
                    $end   = $request->tahun . '-12-31';
                    break;
            }

            $query->whereBetween('tanggal', [$start, $end]);
        }

       if ($request->jenis) {
            $query->where('jenis_permohonan', $request->jenis);
        }

        if ($request->kategori) {
            $query->whereHas('unitKerja', function ($q) use ($request) {
                $q->where('kategori', $request->kategori);
            });
        }

        // ================= STATUS FILTER =================
        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nik', 'like', '%' . $request->search . '%')
                  ->orWhere('nama', 'like', '%' . $request->search . '%');
            });
        }

        $data = $query->latest()->paginate(10);

        return view('permohonan.index', compact('data'));
    }
}
