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
        return view('public.index');
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
    // CEK NIK & TAMPILKAN FORM
    // ===============================
    public function checkNik(Request $request)
    {
        // 1. Ambil NIK dari input form ATAU dari session (jika user me-refresh halaman)
        $nik = $request->nik ?? session('temp_nik');

        // 2. Jika tidak ada NIK sama sekali (sesi habis/akses langsung), kembalikan ke awal
        if (!$nik) {
            return redirect()->route('layanan.index')->withErrors([
                'nik' => 'Sesi telah habis atau data NIK tidak ditemukan. Silakan masukkan kembali.'
            ]);
        }

        // 3. Masukkan kembali NIK ke dalam request agar lolos validasi bawaan Laravel
        $request->merge(['nik' => $nik]);

        // 4. Validasi format bawaan Laravel
        $request->validate([
            'nik' => ['required', 'digits:16']
        ]);

        // 5. Validasi struktur NIK custom (fungsi validNik milik Anda)
        if (!$this->validNik($request->nik)) {
            // Gunakan redirect()->route() bukan back() agar lebih aman dari error routing
            return redirect()->route('layanan.index')->withErrors([
                'nik' => 'NIK tidak valid atau salah ketik.'
            ]);
        }

        // 6. Ambil riwayat permohonan terakhir untuk autofill (jika ada)
        $last = TteLog::where('nik', $request->nik)
            ->orderBy('created_at', 'desc')
            ->first();

        // 7. Ambil data instansi/unit kerja
        $unitKerjas = UnitKerja::orderBy('nama')->get();

        // 8. Simpan NIK ke session agar aman saat halaman form di-refresh
        session(['temp_nik' => $request->nik]);
        
        // 9. Tampilkan halaman form selanjutnya
        return view('public.form', [
            'nik' => $request->nik,
            'last' => $last,
            'unitKerjas' => $unitKerjas
        ]);
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

            'jenis_permohonan' => 'required|in:baru,reset_passphrase,perpanjangan',
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
