<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Permohonan TTE | Kab. Belitung Timur</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

    <div class="h-2 w-full bg-gradient-to-r from-teal-600 via-teal-800 to-amber-500"></div>

    <div class="max-w-4xl mx-auto mt-10 px-4">
        <div class="bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border-0">
            
            <div class="bg-gradient-to-br from-teal-700 via-teal-800 to-amber-600 p-8 md:p-12 text-white relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
                <div class="relative z-10 flex items-center gap-6">
                    <div class="bg-white p-3 rounded-2xl shadow-lg hidden md:block">
                        <img src="{{ asset('img/logo-beltim.png') }}" alt="Logo Beltim" class="h-12">
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-3xl font-black tracking-tight">Form Permohonan Layanan TTE</h1>
                        <p class="text-teal-50/80 text-sm mt-1 italic">Lengkapi data di bawah ini dengan benar</p>
                    </div>
                </div>
            </div>

            <div class="bg-amber-50 border-b border-amber-100 p-4 px-8 md:px-12 flex items-center gap-3">
                <i class="fa-solid fa-shield-halved text-amber-600"></i>
                <p class="text-xs text-amber-800 font-medium italic">
                    Seluruh informasi yang dikumpulkan akan dijaga kerahasiaannya untuk keperluan administrasi yang sah.
                </p>
            </div>

            <form method="POST" action="{{ route('layanan.store') }}" class="p-8 md:p-12">
                @csrf
                <input type="hidden" name="tanggal" value="{{ now()->format('Y-m-d') }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    
                    <div class="form-group">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Nama Lengkap</label>
                        <input type="text" name="nama" class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-600 transition-all outline-none font-semibold text-slate-700"
                               value="{{ $last->nama ?? '' }}" required>
                    </div>

                    <div class="form-group">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">NIK (Sesuai KTP)</label>
                        <input type="text" name="nik" class="w-full px-4 py-3 bg-slate-100 border-2 border-slate-200 rounded-2xl font-bold text-slate-500 cursor-not-allowed"
                               value="{{ $nik }}" readonly>
                    </div>

                    <div class="form-group">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">NIP (Opsional)</label>
                        <input type="text" name="nip" class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-600 transition-all outline-none font-semibold text-slate-700"
                               value="{{ $last->nip ?? '' }}">
                    </div>

                    <div class="form-group">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Nomor WhatsApp/HP</label>
                        <input type="text" name="no_hp" class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-600 transition-all outline-none font-semibold text-slate-700"
                               value="{{ $last->no_hp ?? '' }}" required>
                    </div>

                    <div class="form-group">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Jabatan Saat Ini</label>
                        <input type="text" name="jabatan" class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-600 transition-all outline-none font-semibold text-slate-700"
                               value="{{ $last->jabatan ?? '' }}" required>
                    </div>

                    <div class="form-group">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Kategori Instansi</label>
                        <select id="kategoriSelect" class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-teal-500/10 outline-none font-semibold text-slate-700 appearance-none">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="pemerintahan">Organisasi Perangkat Daerah</option>
                            <option value="sekolah">Satuan Pendidikan (Sekolah)</option>
                            <option value="desa">Pemerintahan Desa</option>
                        </select>
                    </div>

                    <div class="form-group md:col-span-2">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Unit Kerja / Nama Instansi</label>
                        <select name="unit_kerja" id="unitKerjaSelect" class="w-full" required>
                            <option value="">-- Pilih Unit Kerja --</option>
                            @foreach($unitKerjas as $unit)
                                <option value="{{ $unit->nama }}" data-kategori="{{ $unit->kategori }}">
                                    {{ $unit->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <hr class="mb-8 border-slate-100">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="form-group">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Jenis Layanan TTE</label>
                        <select name="jenis_permohonan" class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-teal-500/10 outline-none font-bold text-teal-700" required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="baru" {{ old('jenis_permohonan') == 'baru' ? 'selected' : '' }}>Pendaftaran Baru</option>
                            <option value="reset_passphrase" {{ old('jenis_permohonan') == 'reset_passphrase' ? 'selected' : '' }}>Reset Passphrase</option>
                            <option value="perpanjangan" {{ old('jenis_permohonan') == 'perpanjangan' ? 'selected' : '' }}>Perpanjangan Sertifikat</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Alasan/Keterangan</label>
                        <textarea name="keterangan" rows="1" class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-teal-500/10 outline-none font-semibold text-slate-700" required></textarea>
                    </div>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-teal-700 to-teal-900 text-white font-black py-4 rounded-2xl shadow-xl shadow-teal-900/30 hover:shadow-teal-900/50 hover:-translate-y-1 transition-all flex items-center justify-center gap-3 text-lg mb-8">
                    KIRIM PERMOHONAN SEKARANG
                    <i class="fa-solid fa-paper-plane"></i>
                </button>

                <div class="bg-slate-50 p-6 rounded-[1.5rem] border-2 border-dashed border-slate-200">
                    <p class="text-[11px] text-slate-400 leading-relaxed text-center italic">
                        Dengan mengirim formulir ini, Anda menyatakan bahwa data di atas adalah benar dan menyetujui penggunaan tanda tangan elektronik sesuai ketentuan perundang-undangan.
                    </p>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-8 text-center text-slate-400 text-xs font-medium">
        © {{ date('Y') }} Pemerintah Kabupaten Belitung Timur
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
    $(document).ready(function() {
        let allOptions = $('#unitKerjaSelect option').clone();

        $('#unitKerjaSelect').select2({
            placeholder: "Cari atau pilih unit kerja...",
            width: '100%'
        });

        $('#kategoriSelect').on('change', function() {
            let kategori = $(this).val();
            $('#unitKerjaSelect').empty().append('<option value="">-- Pilih Unit Kerja --</option>');
            
            allOptions.each(function() {
                if ($(this).data('kategori') == kategori || $(this).val() == "") {
                    $('#unitKerjaSelect').append($(this).clone());
                }
            });
            $('#unitKerjaSelect').val('').trigger('change');
        });
    });
    </script>
</body>
</html>