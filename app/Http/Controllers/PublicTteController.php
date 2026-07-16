<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TteLog;
use App\Models\UnitKerja;
use Illuminate\Validation\Rule;

class PublicTteController extends Controller
{
    // Halaman awal (input NIK)
    public function index()
    {
        return view('public.cek_nik');
    }

    // ===============================
    // VALIDASI STRUKTUR NIK
    // ===============================
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

        // ===============================
    // CEK NIK & TAMPILKAN FORM PERMOHONAN
    // ===============================
    public function checkNik(Request $request)
    {
        $nik = $request->nik ?? session('temp_nik');

        if (!$nik) {
            return redirect()->route('layanan.index')->withErrors([
                'nik' => 'Sesi telah habis atau data NIK tidak ditemukan. Silakan masukkan kembali.'
            ]);
        }

        $request->merge(['nik' => $nik]);
        $request->validate([
            'nik' => ['required', 'digits:16']
        ]);

        if (!$this->validNik($request->nik)) {
            return redirect()->route('layanan.index')->withErrors([
                'nik' => 'NIK tidak valid atau salah ketik.'
            ]);
        }

        // =========================================================
        // CEK APAKAH MASIH ADA PERMOHONAN PENDING (BELUM DIPROSES)
        // =========================================================
        // CATATAN: Sesuaikan 'status' dan 'pending' dengan nama kolom & value di database Anda.
        $cekPending = TteLog::where('nik', $request->nik)
                            ->where('status', 'pending') // Ubah jika di DB Anda berbeda (misal: '0' atau 'diproses')
                            ->exists();

        if ($cekPending) {
            return redirect()->route('layanan.check')->withErrors([
                'nik' => 'Anda masih memiliki permohonan yang sedang diproses (status pending). Mohon tunggu hingga permohonan sebelumnya selesai diproses oleh Admin.'
            ]);
        }

        // =========================================================

        $last = TteLog::where('nik', $request->nik)
            ->orderBy('created_at', 'desc')
            ->first();

        $unitKerjas = UnitKerja::orderBy('nama')->get();

        session(['temp_nik' => $request->nik]);
        
        return view('public.form', [
            'nik' => $request->nik,
            'last' => $last,
            'unitKerjas' => $unitKerjas
        ]);
    }

        // ===============================
    // TAMPILKAN HALAMAN CEK NIK (UNTUK LAPOR KENDALA)
    // ===============================
    public function formKendalaNik()
    {
        // Kita kirim variabel 'mode' agar di view cek_nik tahu kalau ini untuk lapor kendala
        return view('public.cek_nik', ['mode' => 'kendala']);
    }

        // ===============================
    // PROSES CEK NIK & TAMPILKAN FORM LAPOR KENDALA
    // ===============================
    public function checkKendalaNik(Request $request)
    {
        $nik = $request->nik ?? session('temp_nik_kendala');

        if (!$nik) {
            return redirect()->route('layanan.kendala')->withErrors([
                'nik' => 'Sesi telah habis atau data NIK tidak ditemukan. Silakan masukkan kembali.'
            ]);
        }

        $request->merge(['nik' => $nik]);
        $request->validate(['nik' => ['required', 'digits:16']]);

        if (!$this->validNik($request->nik)) {
            return redirect()->route('layanan.kendala')->withErrors([
                'nik' => 'NIK tidak valid atau salah ketik.'
            ]);
        }

        // =========================================================
        // CEK APAKAH MASIH ADA LAPORAN KENDALA PENDING
        // =========================================================
        $cekPendingKendala = TteLog::where('nik', $request->nik)
                            ->where('jenis_permohonan', 'lapor_kendala')
                            ->where('status', 'pending') // Sesuaikan dengan kolom DB Anda
                            ->exists();

        if ($cekPendingKendala) {
            return redirect()->route('layanan.kendala')->withErrors([
                'nik' => 'Anda masih memiliki laporan kendala yang sedang ditinjau. Tim teknis akan segera menghubungi Anda melalui WhatsApp.'
            ]);
        }

        // =========================================================

        $last = TteLog::where('nik', $request->nik)->orderBy('created_at', 'desc')->first();
        $unitKerjas = UnitKerja::orderBy('nama')->get();

        session(['temp_nik_kendala' => $request->nik]);
        
        return view('public.form_kendala', [
            'nik' => $request->nik,
            'last' => $last,
            'unitKerjas' => $unitKerjas
        ]);
    }

        // ===============================
    // SIMPAN DATA LAPOR KENDALA
    // ===============================
    public function storeKendala(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nik' => 'required',
            'no_hp' => 'required',
            'jabatan' => 'required',
            'unit_kerja' => 'required',
            'keterangan' => 'required',
            'bukti_kendala' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $data = $request->except('bukti_kendala');
        $data['jenis_permohonan'] = 'lapor_kendala';
        $data['tanggal'] = now()->format('Y-m-d');

        if ($request->hasFile('bukti_kendala')) {
            $file = $request->file('bukti_kendala');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/bukti_kendala', $filename);
            $data['bukti_kendala'] = $filename;
        }

        TteLog::create($data);

        return redirect()->route('layanan.index')->with('success', 'Laporan kendala Anda berhasil dikirim! Tim teknis akan segera menindaklanjuti.');
    }
    
    // ===============================
    // SIMPAN PERMOHONAN
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nama' => 'required|string|max:100',

            // NIK 16 digit angka
            'nik' => ['required','regex:/^[0-9]{16}$/'],

            // VALIDASI NIP (rapi tapi tidak ribet)
            'nip' => [
                'nullable',
                'digits:18',
                function ($attribute, $value, $fail) {

                    // Validasi tanggal lahir (YYYYMMDD)
                    $tgl = substr($value, 0, 8);
                    $tahun = substr($tgl, 0, 4);
                    $bulan = substr($tgl, 4, 2);
                    $hari  = substr($tgl, 6, 2);

                    if (!checkdate((int)$bulan, (int)$hari, (int)$tahun)) {
                        $fail('Format tanggal lahir pada NIP tidak valid.');
                    }

                    // Validasi TMT (YYYYMM)
                    $tmt = substr($value, 8, 6);
                    $tahunTmt = substr($tmt, 0, 4);
                    $bulanTmt = substr($tmt, 4, 2);

                    if ($bulanTmt < 1 || $bulanTmt > 12) {
                        $fail('Format TMT pada NIP tidak valid.');
                    }

                    // TMT tidak boleh lebih kecil dari tahun lahir
                    if ((int)$tahunTmt < (int)$tahun) {
                        $fail('TMT tidak logis dibanding tahun lahir.');
                    }
                }
            ],

            'jabatan' => 'required|string|max:100',

            // Unit kerja harus ada di database
            'unit_kerja' => [
                'required',
                Rule::exists('unit_kerjas', 'nama')
            ],

            // Nomor HP harus mulai 08 dan 10–13 digit
            'no_hp' => ['required','regex:/^08[0-9]{8,11}$/'],

            // TAMBAHKAN 'penghapusan' DISINI
            'jenis_permohonan' => 'required|in:baru,reset_passphrase,perpanjangan,penghapusan',
            
            'keterangan' => 'required|string|max:500',
        ]);

        TteLog::create([
            'tanggal' => now(),
            'nama' => $request->nama,
            'nik' => $request->nik,
            'nip' => $request->nip,
            'jabatan' => $request->jabatan,
            'unit_kerja' => $request->unit_kerja,
            'no_hp' => $request->no_hp,
            'jenis_permohonan' => $request->jenis_permohonan,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('layanan.index')
            ->with('success', 'Permohonan Anda telah berhasil dikirim. Mohon menunggu proses verifikasi dari Tim Verifikator TTE.');
    }
}