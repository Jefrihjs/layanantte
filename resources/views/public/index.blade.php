<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusat Layanan TTE | Kab. Belitung Timur</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between">

    <div class="h-2 w-full bg-gradient-to-r from-teal-600 via-teal-800 to-amber-500"></div>

    <div class="wrapper flex-grow flex items-center justify-center p-6">
        <div class="max-w-2xl w-full">
            
                        <!-- Header -->
            <div class="text-center mb-10">
                <div class="bg-white p-3 rounded-2xl inline-block shadow-lg mb-4">
                    <img src="{{ asset('img/logo-beltim.png') }}" alt="Logo Beltim" class="h-16 mx-auto">
                </div>
                <h1 class="text-3xl font-extrabold tracking-tight text-slate-800">Pusat Layanan TTE</h1>
                <p class="text-slate-500 text-sm mt-2">Pemerintah Kabupaten Belitung Timur</p>
            </div>

            {{-- ✅ ALERT SUKSES/GAGAL --}}
            @if(session()->has('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-xl mb-8 text-sm flex items-center gap-3 shadow-sm animate-bounce">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-xl"></i>
                    <span class="font-semibold">{{ session('success') }}</span>
                </div>
            @endif

            @if(session()->has('error'))
                <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-xl mb-8 text-sm flex items-center gap-3 shadow-sm">
                    <i class="fa-solid fa-circle-exclamation text-red-500 text-xl"></i>
                    <span class="font-semibold">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Menu Pilihan -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Menu 1: Permohonan TTE -->
                <a href="{{ route('layanan.check') }}" class="group bg-white rounded-[2rem] shadow-xl p-8 border-2 border-transparent hover:border-teal-500 hover:-translate-y-2 transition-all duration-300 flex flex-col items-center text-center">
                    <div class="bg-teal-50 p-5 rounded-2xl mb-5 group-hover:bg-teal-100 transition-colors">
                        <i class="fa-solid fa-file-signature text-4xl text-teal-600"></i>
                    </div>
                    <h2 class="text-xl font-black text-slate-800 mb-2">Permohonan TTE</h2>
                    <p class="text-sm text-slate-500 leading-relaxed mb-6">Pendaftaran, Reset Passphrase, Perpanjangan, atau Penghapusan Sertifikat Elektronik.</p>
                    <span class="mt-auto bg-teal-600 text-white text-xs font-bold py-2 px-6 rounded-full group-hover:bg-teal-700 transition-colors">
                        Ajukan Permohonan <i class="fa-solid fa-arrow-right ml-1"></i>
                    </span>
                </a>

                <!-- Menu 2: Lapor Kendala -->
                <a href="{{ route('layanan.kendala') }}" class="group bg-white rounded-[2rem] shadow-xl p-8 border-2 border-transparent hover:border-red-500 hover:-translate-y-2 transition-all duration-300 flex flex-col items-center text-center">
                    <div class="bg-red-50 p-5 rounded-2xl mb-5 group-hover:bg-red-100 transition-colors">
                        <i class="fa-solid fa-triangle-exclamation text-4xl text-red-500"></i>
                    </div>
                    <h2 class="text-xl font-black text-slate-800 mb-2">Lapor Kendala TTE</h2>
                    <p class="text-sm text-slate-500 leading-relaxed mb-6">Mengalami error, gagal sistem, atau masalah verifikasi? Sampaikan laporan Anda di sini.</p>
                    <span class="mt-auto bg-red-500 text-white text-xs font-bold py-2 px-6 rounded-full group-hover:bg-red-600 transition-colors">
                        Buat Laporan <i class="fa-solid fa-arrow-right ml-1"></i>
                    </span>
                </a>

            </div>

            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 mt-8 flex gap-3">
                <i class="fa-solid fa-circle-info text-teal-600 mt-1"></i>
                <p class="text-[11px] text-slate-500 leading-relaxed italic">
                    Pastikan Anda memilih menu yang sesuai dengan kebutuhan. Jika Anda belum pernah mendaftar TTE, silakan pilih menu Permohonan TTE.
                </p>
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