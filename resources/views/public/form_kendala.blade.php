<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Lapor Kendala TTE | Kab. Belitung Timur</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- TAMBAHAN CSS & JS SELECT2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f1f5f9; }
        /* Custom Select2 Styling agar menyatu dengan Tailwind */
        .select2-container--default .select2-selection--single {
            border: 2px solid #f1f5f9 !important;
            border-radius: 1rem !important;
            height: 52px !important;
            padding: 10px !important;
            background-color: #f8fafc !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow { height: 50px !important; }
    </style>
</head>
<body class="min-h-screen pb-12">

    <div class="h-2 w-full bg-gradient-to-r from-red-500 via-red-600 to-amber-500"></div>

    <div class="max-w-4xl mx-auto mt-10 px-4">
        <div class="bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border-0">
            
            <div class="bg-gradient-to-br from-red-600 via-red-700 to-amber-600 p-8 md:p-12 text-white relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                <div class="relative z-10 flex items-center gap-6">
                    <div class="bg-white p-3 rounded-2xl shadow-lg hidden md:block">
                        <img src="{{ asset('img/logo-beltim.png') }}" alt="Logo Beltim" class="h-12">
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-black tracking-tight">Formulir Pelaporan Kendala TTE</h1>
                        <p class="text-red-50/80 text-sm mt-1 italic">Sampaikan kronologi error yang Anda alami</p>
                    </div>
                </div>
            </div>

            <!-- TOMBOL KEMBALI -->
            <div class="bg-slate-50 border-b border-slate-100 p-4 px-8 md:px-12">
                <a href="{{ route('layanan.index') }}" class="text-xs font-bold text-slate-500 hover:text-teal-600 flex items-center gap-2 w-fit">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Menu Utama
                </a>
            </div>

            <!-- FORM -->
            <form method="POST" action="{{ route('layanan.kendala.store') }}" enctype="multipart/form-data" class="p-8 md:p-12">
                @csrf
                
                <input type="hidden" name="tanggal" value="{{ now()->format('Y-m-d') }}">
                <input type="hidden" name="jenis_permohonan" value="lapor_kendala">

                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-xl shadow-sm">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fa-solid fa-circle-exclamation text-red-500 text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-black text-red-800 uppercase">Terjadi Kesalahan!</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc list-inside space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('success'))
                    <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 mb-6 rounded-r-xl shadow-sm">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fa-solid fa-circle-check text-emerald-500 text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-bold text-emerald-800">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    
                    <div class="form-group">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Nama Lengkap</label>
                        <input type="text" name="nama" class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-red-500/10 focus:border-red-600 transition-all outline-none font-semibold text-slate-700" value="{{ old('nama', $last->nama ?? '') }}" required>
                    </div>

                    <div class="form-group">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">NIK (Sesuai KTP)</label>
                        <input type="text" name="nik" maxlength="16" class="w-full px-4 py-3 bg-slate-100 border-2 border-slate-200 rounded-2xl font-bold text-slate-500 cursor-not-allowed" value="{{ $nik ?? old('nik') }}" readonly>
                    </div>

                    <div class="form-group">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Nomor WhatsApp/HP</label>
                        <input type="text" name="no_hp" class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-red-500/10 focus:border-red-600 transition-all outline-none font-semibold text-slate-700" value="{{ old('no_hp', $last->no_hp ?? '') }}" required>
                    </div>

                    <div class="form-group">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Jabatan Saat Ini</label>
                        <input type="text" name="jabatan" class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-red-500/10 focus:border-red-600 transition-all outline-none font-semibold text-slate-700" value="{{ old('jabatan', $last->jabatan ?? '') }}" required>
                    </div>

                    <!-- INI BAGIAN DROPDOWN PENCARIAN UNIT KERJA -->
                    <div class="form-group md:col-span-2">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Unit Kerja / Nama Instansi</label>
                        <select name="unit_kerja" id="unitKerjaSelect" class="w-full" required>
                            <option value="">-- Cari Unit Kerja --</option>
                            @foreach($unitKerjas as $unit)
                                <option value="{{ $unit->nama }}" {{ old('unit_kerja', $last->unit_kerja ?? '') == $unit->nama ? 'selected' : '' }}>
                                    {{ $unit->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <hr class="mb-8 border-slate-100">

                <div class="grid grid-cols-1 gap-6 mb-8">
                    <!-- KETERANGAN GAGAL (KRONOLOGI) -->
                    <div class="form-group">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Keterangan Gagal (Kronologi Error)</label>
                        <textarea name="keterangan" rows="4" class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-red-500/10 focus:border-red-600 outline-none font-semibold text-slate-700" placeholder="Jelaskan langkah yang Anda lakukan hingga muncul error, dan pesan error apa yang muncul..." required>{{ old('keterangan') }}</textarea>
                    </div>

                    <!-- UNGGAH BUKTI -->
                    <div class="form-group">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Unggah Bukti Kendala (Screenshot / Tangkapan Layar) - <span class="text-slate-300 normal-case">Opsional</span></label>
                        <div class="flex items-center justify-center w-full">
                            <label for="bukti_kendala" class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-200 border-dashed rounded-2xl cursor-pointer bg-slate-50 hover:bg-slate-100 transition-all">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <i class="fa-solid fa-cloud-arrow-up text-3xl text-slate-400 mb-2"></i>
                                    <p class="text-sm text-slate-500 font-semibold">Klik untuk unggah file</p>
                                    <p class="text-xs text-slate-400">PNG, JPG, atau PDF (Max. 2MB)</p>
                                </div>
                                <input id="bukti_kendala" name="bukti_kendala" type="file" class="hidden" accept="image/*,application/pdf" onchange="document.getElementById('file-name').textContent = this.files[0] ? this.files[0].name : 'Tidak ada file dipilih'">
                            </label>
                        </div>
                        <p id="file-name" class="text-xs text-slate-500 mt-2 ml-1 font-medium">Tidak ada file dipilih</p>
                    </div>
                </div>

                <!-- TOMBOL SUBMIT -->
                <button type="submit" class="w-full bg-gradient-to-r from-red-600 to-red-800 text-white font-black py-4 rounded-2xl shadow-xl hover:shadow-red-900/50 hover:-translate-y-1 transition-all flex items-center justify-center gap-3 text-lg mb-4">
                    KIRIM LAPORAN KENDALA
                    <i class="fa-solid fa-paper-plane"></i>
                </button>

                <div class="bg-slate-50 p-6 rounded-[1.5rem] border-2 border-dashed border-slate-200">
                    <p class="text-[11px] text-slate-400 leading-relaxed text-center italic">
                        Tim teknis akan meninjau laporan Anda dan menghubungi nomor WhatsApp yang terdaftar untuk penanganan lebih lanjut.
                    </p>
                </div>
            </form>
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
    
    <!-- TAMBAHAN JS SELECT2 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Inisialisasi Select2 untuk Unit Kerja
            $('#unitKerjaSelect').select2({
                placeholder: "Ketik untuk mencari unit kerja...",
                width: '100%',
                allowClear: true
            });
        });
    </script>
</body>
</html>