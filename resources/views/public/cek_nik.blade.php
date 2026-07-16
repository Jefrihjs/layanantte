<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Layanan TTE | Kab. Belitung Timur</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between">

    <div class="h-2 w-full bg-gradient-to-r from-teal-600 via-teal-800 to-amber-500"></div>

    <div class="wrapper flex-grow flex items-center justify-center p-6">
        <div class="max-w-md w-full">
            
            <div class="card glass-effect rounded-[2.5rem] shadow-2xl overflow-hidden border-0">
                
                <!-- HEADER DINAMIS -->
                @php $isKendala = ($mode ?? 'permohonan') == 'kendala'; @endphp
                <div class="p-10 text-white text-center relative overflow-hidden {{ $isKendala ? 'bg-gradient-to-br from-red-600 via-red-700 to-amber-600' : 'bg-gradient-to-br from-teal-700 via-teal-800 to-amber-600' }}">
                    <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full"></div>
                    
                    <div class="relative z-10">
                        <div class="bg-white p-3 rounded-2xl inline-block shadow-lg mb-4">
                            <img src="{{ asset('img/logo-beltim.png') }}" alt="Logo Beltim" class="h-16 mx-auto">
                        </div>
                        <h1 class="text-2xl font-extrabold tracking-tight">{{ $isKendala ? 'Lapor Kendala TTE' : 'Layanan Permohonan TTE' }}</h1>
                        <p class="{{ $isKendala ? 'text-red-50/80' : 'text-teal-50/80' }} text-sm mt-2">Pemerintah Kabupaten Belitung Timur</p>
                    </div>
                </div>

                <div class="p-8 md:p-10">
                    
                    <!-- TOMBOL KEMBALI KE MENU UTAMA -->
                    <div class="mb-6">
                        <a href="{{ route('layanan.index') }}" class="text-xs font-bold text-slate-400 hover:text-teal-600 flex items-center gap-2 w-fit">
                            <i class="fa-solid fa-arrow-left"></i> Kembali ke Menu Utama
                        </a>
                    </div>

                    <div class="text-center mb-8">
                        <h2 class="text-slate-800 font-bold text-lg">Validasi Identitas</h2>
                        <!-- TEKS DINAMIS BERDASARKAN MODE -->
                        <p class="text-slate-500 text-sm mt-1">
                            {{ $isKendala ? 'Masukkan NIK untuk melapor kendala' : 'Masukkan NIK untuk mengecek status permohonan' }}
                        </p>
                    </div>

                    {{-- ✅ ALERT SUKSES --}}
                    @if(session()->has('success'))
                        <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-xl mb-6 text-sm flex items-center gap-3 shadow-sm">
                            <i class="fa-solid fa-circle-check text-emerald-500"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- ✅ ACTION FORM DINAMIS BERDASARKAN MODE --}}
                    <form method="POST" action="{{ $isKendala ? route('layanan.kendala.check.post') : route('layanan.check.post') }}" class="space-y-6">
                        @csrf

                        <div class="form-group">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Nomor Induk Kependudukan (NIK)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-id-card text-slate-400"></i>
                                </div>
                                <input type="text"
                                       name="nik"
                                       maxlength="16"
                                       placeholder="Masukkan 16 digit NIK"
                                       class="w-full pl-11 pr-4 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-600 transition-all outline-none font-bold text-slate-700 @error('nik') border-red-300 bg-red-50 @enderror"
                                       value="{{ old('nik') }}"
                                       required>
                            </div>

                            @error('nik')
                                <div class="flex items-center gap-2 mt-2 ml-1 text-red-500 text-xs font-bold">
                                    <i class="fa-solid fa-circle-exclamation"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- TOMBOL SUBMIT DINAMIS WARNA -->
                        <button type="submit" class="w-full text-white font-black py-4 rounded-2xl shadow-lg transition-all flex items-center justify-center gap-3 {{ $isKendala ? 'bg-gradient-to-r from-red-600 to-red-800 shadow-red-900/30 hover:shadow-red-900/50' : 'bg-gradient-to-r from-teal-700 to-teal-900 shadow-teal-900/30 hover:shadow-teal-900/50' }} hover:-translate-y-1">
                            LANJUTKAN
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>

                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100">
                            <div class="flex gap-3">
                                <i class="fa-solid fa-circle-info text-teal-600 mt-1"></i>
                                <p class="text-[11px] text-slate-500 leading-relaxed italic">
                                    Formulir ini digunakan untuk proses layanan tanda tangan elektronik sebagai bentuk persetujuan dan pengesahan dokumen secara sah di lingkungan Pemerintah Kabupaten Belitung Timur.
                                </p>
                            </div>
                        </div>

                    </form>
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