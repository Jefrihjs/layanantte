<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect; // <-- Tambahkan ini untuk fungsi redirect ke WA
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

        $data = $query->latest('tanggal')->paginate(10)->withQueryString();

        return view('permohonan.index', compact('data'));
    }

    // ================= FUNGSI BARU UNTUK PROSES & WA =================
    public function prosesPermohonan(Request $request, $id)
    {
        // 1. Validasi input email
        $request->validate([
            'email' => 'required|email'
        ]);

        // 2. Ambil data permohonan 
        $log = TteLog::findOrFail($id); 
        
        // 3. Update status permohonan menjadi diproses
        $log->status = 'diproses';
        $log->email = $request->email;

        $log->diproses_oleh = auth()->id(); 
        $log->diproses_pada = now();

        $log->save();

        // 4. Format nomor HP (Ubah 0 di depan menjadi 62)
        $no_hp = $log->no_hp;
        if (substr($no_hp, 0, 1) === '0') {
            $no_hp = '62' . substr($no_hp, 1);
        }

        // 5. Tentukan label jenis permohonan
        $jenis_teks = 'Pendaftaran Baru'; // Default
        if ($log->jenis_permohonan == 'reset_passphrase') {
            $jenis_teks = 'Reset Passphrase';
        } elseif ($log->jenis_permohonan == 'perpanjangan') {
            $jenis_teks = 'Perpanjangan Sertifikat';
        }

        // 6. Susun isi pesan WhatsApp
        $email = $request->email;
        $verifikator = auth()->check()
        ? auth()->user()->name
        : 'Verifikator TTE';

        $pesan = "Halo Bpk/Ibu {$log->nama}, permohonan *{$jenis_teks}* Anda saat ini sedang diproses.\n\n";

        $pesan .= "Harap cek webmail Anda secara berkala, karena link dan informasi terkait permohonan tersebut akan dikirimkan langsung oleh pihak BSrE ke email Anda.\n\n";

        $pesan .= "Berikut adalah akses Webmail Anda:\n";
        $pesan .= "Link: https://webmail.beltim.go.id/\n";
        $pesan .= "Username: {$email}\n";
        $pesan .= "Password: Beltimur@[tahun_lahir]\n\n";
        $pesan .= "*Catatan: Ganti [tahun_lahir] dengan 4 digit tahun lahir Anda (contoh: Beltimur@1990).*\n\n";

        $pesan .= "*Ketentuan Passphrase:*\n";
        $pesan .= "- Minimal 8 karakter\n";
        $pesan .= "- Terdiri dari huruf besar\n";
        $pesan .= "- Terdiri dari huruf kecil\n";
        $pesan .= "- Terdiri dari angka\n";
        $pesan .= "- Terdiri dari simbol, misalnya: !@#$%^&*.,()\n\n";

        $pesan .= "*Tutorial Penggunaan Layanan TTE:*\n";
        $pesan .= "1. Tutorial Registrasi TTE Baru:\n";
        $pesan .= "https://youtu.be/VR-vkpmOYic?si=tjSEGidR9KnRB_KK\n\n";

        $pesan .= "2. Tutorial Pembaruan TTE Expired:\n";
        $pesan .= "https://youtu.be/6LownTACk_Y?si=JPuJ5TG4MRHfpeou\n\n";

        $pesan .= "3. Tutorial Verifikasi WA Pengguna TTE dan Reset TTE:\n";
        $pesan .= "https://youtu.be/601tZLvZtTc?si=OhmW8X7EDkCDGMzA\n";
        $pesan .= "https://s.id/resetTTE\n\n";

        $pesan .= "Pesan ini dikirim oleh Verifikator:\n";
        $pesan .= "{$verifikator}";

        // 7. Buat Link WA dan Redirect
        $wa_url = "https://wa.me/{$no_hp}?text=" . urlencode($pesan);

        return Redirect::away($wa_url);
    }
}