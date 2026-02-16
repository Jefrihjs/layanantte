<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TteLog;
use Carbon\Carbon;

class PublicTteController extends Controller
{
    // Halaman awal (input NIK)
    public function index()
    {
        return view('public.index');
    }

    private function validNik($nik)
    {
        // Harus 16 digit angka
        if (!preg_match('/^[0-9]{16}$/', $nik)) {
            return false;
        }

        // Tidak boleh semua nol
        if ($nik === str_repeat('0', 16)) {
            return false;
        }

        // Ambil bagian tanggal lahir
        $tanggal = (int) substr($nik, 6, 2);
        $bulan   = (int) substr($nik, 8, 2);
        $tahun   = (int) substr($nik, 10, 2);

        // Perempuan (+40)
        if ($tanggal > 40) {
            $tanggal -= 40;
        }

        // Tentukan tahun lengkap
        $tahunSekarang = (int) date('y');
        $tahunLengkap = ($tahun <= $tahunSekarang)
            ? 2000 + $tahun
            : 1900 + $tahun;

        // Validasi tanggal
        if (!checkdate($bulan, $tanggal, $tahunLengkap)) {
            return false;
        }

        // Validasi nomor urut (digit 13–16)
        $urut = (int) substr($nik, 12, 4);

        if ($urut < 1 || $urut > 100) {
            return false;
        }

        return true;
    }



    // Cek NIK & tampilkan form
    public function checkNik(Request $request)
    {
        $request->validate([
            'nik' => ['required', 'digits:16']
        ]);

        if (!$this->validNik($request->nik)) {
            return back()->withErrors([
                'nik' => 'NIK tidak valid atau salah ketik.'
            ]);
        }

        // Ambil riwayat terakhir jika ada
        $last = TteLog::where('nik', $request->nik)
            ->orderBy('created_at', 'desc')
            ->first();

        return view('public.form', [
            'nik'  => $request->nik,
            'last' => $last
        ]);
    }



    // Simpan permohonan
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nama' => 'required|string',
            'nik' => 'required|digits:16',
            'jabatan' => 'required|string',
            'unit_kerja' => 'required|string',
            'no_hp' => 'required|string',
            'jenis_permohonan' => 'required|in:baru,reset_passphrase,perpanjangan',
            'keterangan' => 'required|string',
        ]);

        TteLog::create([
            'tanggal' => $request->tanggal,
            'nama' => $request->nama,
            'nik' => $request->nik,
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'unit_kerja' => $request->unit_kerja,
            'no_hp' => $request->no_hp,
            'jenis_permohonan' => $request->jenis_permohonan,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('tte.index')
            ->with('success', 'Permohonan berhasil dicatat.');
    }
}
