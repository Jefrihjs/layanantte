<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Syarat dan Ketentuan | Kab. Belitung Timur</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }</style>
</head>
<body class="min-h-screen flex flex-col justify-between">
    <div class="h-2 w-full bg-gradient-to-r from-teal-600 via-teal-800 to-amber-500"></div>

    <div class="wrapper flex-grow flex items-center justify-center p-6">
        <div class="max-w-3xl w-full bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border-0">
            <div class="bg-gradient-to-br from-teal-700 via-teal-800 to-amber-600 p-8 text-white text-center">
                <h1 class="text-2xl font-extrabold tracking-tight">Syarat dan Ketentuan</h1>
                <p class="text-teal-50/80 text-sm mt-2">Layanan Permohonan Tanda Tangan Elektronik (TTE)</p>
            </div>

            <div class="p-8 md:p-12 text-sm text-slate-600 leading-relaxed space-y-4">
                <a href="{{ route('layanan.index') }}" class="text-xs font-bold text-slate-400 hover:text-teal-600 flex items-center gap-2 w-fit mb-6">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Menu Utama
                </a>

                <p class="font-bold text-slate-800">Dinas Komunikasi, Informatika, Statistik, dan Persandian Kabupaten Belitung Timur</p>
                <p>Sebelum mengirimkan permohonan, mohon membaca Syarat dan Ketentuan berikut dengan saksama.</p>

                <div class="space-y-4">
                    <div>
                        <h3 class="font-bold text-slate-800">1. Tujuan Pengumpulan Data Pribadi</h3>
                        <p>Data pribadi yang Anda isikan pada formulir ini dikumpulkan semata-mata untuk keperluan proses layanan Tanda Tangan Elektronik (TTE), yaitu:</p>
                        <ul class="list-disc list-inside ml-2 mt-1">
                            <li>1.1. pendaftaran sertifikat elektronik;</li>
                            <li>1.2. reset passphrase;</li>
                            <li>1.3. perpanjangan sertifikat elektronik; dan/atau</li>
                            <li>1.4. penghapusan sertifikat elektronik.</li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="font-bold text-slate-800">2. Data Pribadi yang Dikumpulkan</h3>
                        <p>Untuk memproses permohonan, kami mengumpulkan data berikut: Nama lengkap, NIK, NIP (opsional), Nomor WhatsApp/HP, Jabatan, Kategori instansi, Unit kerja, Jenis layanan, dan Alasan/keterangan.</p>
                    </div>

                    <div>
                        <h3 class="font-bold text-slate-800">3. Dasar Pemrosesan Data Pribadi</h3>
                        <p>Pemrosesan data pribadi Anda dilaksanakan berdasarkan persetujuan eksplisit yang Anda berikan pada saat mengirimkan formulir ini, sesuai dengan Undang-Undang Nomor 27 Tahun 2022 tentang Pelindungan Data Pribadi.</p>
                    </div>

                    <div>
                        <h3 class="font-bold text-slate-800">4. Penyimpanan Data Pribadi</h3>
                        <ul class="list-disc list-inside ml-2">
                            <li>4.1. Data pribadi Anda disimpan selama sertifikat elektronik Anda masih aktif dan/atau selama diperlukan untuk keperluan administrasi layanan TTE.</li>
                            <li>4.2. Data pribadi disimpan dengan menerapkan langkah keamanan yang memadai untuk mencegah akses, penggunaan, atau pengungkapan yang tidak sah.</li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="font-bold text-slate-800">5. Pernyataan Persetujuan</h3>
                        <p>Dengan mengirimkan formulir ini, Anda menyatakan bahwa data yang diisikan adalah benar dan dapat dipertanggungjawabkan, serta menyetujui penggunaan tanda tangan elektronik sesuai ketentuan peraturan perundang-undangan yang berlaku.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <div class="footer py-8 text-center text-slate-400 text-xs font-medium">
        <div class="flex justify-center items-center gap-4 mb-3">
            <a href="{{ route('kebijakan.privasi') }}" class="hover:text-teal-600 transition-colors">Kebijakan Privasi</a>
            <span class="text-slate-300">|</span>
            <a href="{{ route('syarat.ketentuan') }}" class="hover:text-teal-600 transition-colors">Syarat & Ketentuan</a>
        </div>
        <p>© {{ date('Y') }} Diskominfo Belitung Timur</p>
        <p class="mt-1 opacity-60 italic text-[10px]">Tanda Tangan Elektronik yang Sah dan Terpercaya</p>
    </div>
</body>
</html>