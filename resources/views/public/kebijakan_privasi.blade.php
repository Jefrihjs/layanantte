<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kebijakan Privasi | Kab. Belitung Timur</title>
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
                <h1 class="text-2xl font-extrabold tracking-tight">Kebijakan Privasi</h1>
                <p class="text-teal-50/80 text-sm mt-2">Layanan Permohonan Tanda Tangan Elektronik (TTE)</p>
            </div>

            <div class="p-8 md:p-12 text-sm text-slate-600 leading-relaxed space-y-4">
                <a href="{{ route('layanan.index') }}" class="text-xs font-bold text-slate-400 hover:text-teal-600 flex items-center gap-2 w-fit mb-6">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Menu Utama
                </a>

                <p>Kebijakan Privasi ini menjelaskan bagaimana Dinas Komunikasi, Informatika, Statistik, dan Persandian Kabupaten Belitung Timur mengumpulkan, menggunakan, dan melindungi data pribadi Anda saat menggunakan layanan Tanda Tangan Elektronik (TTE).</p>

                <div class="space-y-4">
                    <div>
                        <h3 class="font-bold text-slate-800">1. Pengumpulan Informasi</h3>
                        <p>Kami mengumpulkan informasi pribadi seperti Nama, NIK, NIP, Nomor HP, Jabatan, dan Unit Kerja untuk keperluan identifikasi dan verifikasi sertifikat elektronik.</p>
                    </div>

                    <div>
                        <h3 class="font-bold text-slate-800">2. Penggunaan Informasi</h3>
                        <p>Informasi yang dikumpulkan digunakan semata-mata untuk memproses permohonan TTE Anda, berkomunikasi mengenai status permohonan, dan memenuhi kewajiban hukum yang berlaku.</p>
                    </div>

                    <div>
                        <h3 class="font-bold text-slate-800">3. Pengungkapan Data Pribadi</h3>
                        <p>Data pribadi Anda tidak akan dibagikan kepada pihak ketiga di luar keperluan proses sertifikat elektronik, kecuali diwajibkan oleh ketentuan peraturan perundang-undangan. Dalam hal proses verifikasi diperlukan, data dapat diteruskan kepada Otoritas Penyelenggara Sertifikasi Elektronik (BSrE-BSSN).</p>
                    </div>

                    <div>
                        <h3 class="font-bold text-slate-800">4. Keamanan Data</h3>
                        <p>Kami menerapkan langkah-langkah keamanan teknis dan organisasi yang memadai untuk melindungi data pribadi Anda dari akses tidak sah, pengungkapan, atau pengubahan tanpa izin.</p>
                    </div>

                    <div>
                        <h3 class="font-bold text-slate-800">5. Hak Subjek Data</h3>
                        <p>Anda berhak untuk mengakses, memperbaiki, atau mengajukan penghapusan data pribadi Anda. Jika Anda ingin menggunakan hak ini, silakan hubungi tim teknis melalui kontak yang tersedia.</p>
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