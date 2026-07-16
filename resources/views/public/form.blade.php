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

                <!-- BLOK UNTUK MENAMPILKAN ERROR VALIDASI -->
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

                <!-- BLOK UNTUK MENAMPILKAN PESAN SUKSES -->
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
                        <input type="text" name="nama" class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-600 transition-all outline-none font-semibold text-slate-700"
                               value="{{ old('nama', $last->nama ?? '') }}" required>
                    </div>

                    <div class="form-group">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">NIK (Sesuai KTP)</label>
                        <input type="text" name="nik" class="w-full px-4 py-3 bg-slate-100 border-2 border-slate-200 rounded-2xl font-bold text-slate-500 cursor-not-allowed"
                               value="{{ $nik ?? session('temp_nik') }}" readonly>
                    </div>

                    <div class="form-group">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">NIP (Opsional)</label>
                        <input type="text" name="nip" class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-600 transition-all outline-none font-semibold text-slate-700"
                               value="{{ old('nip', $last->nip ?? '') }}">
                    </div>

                    <div class="form-group">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Nomor WhatsApp/HP</label>
                        <input type="text" name="no_hp" class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-600 transition-all outline-none font-semibold text-slate-700"
                               value="{{ old('no_hp', $last->no_hp ?? '') }}" required>
                    </div>

                    <div class="form-group">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Jabatan Saat Ini</label>
                        <input type="text" name="jabatan" class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-teal-500/10 focus:border-teal-600 transition-all outline-none font-semibold text-slate-700"
                               value="{{ old('jabatan', $last->jabatan ?? '') }}" required>
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
                                <option value="{{ $unit->nama }}" data-kategori="{{ $unit->kategori }}" {{ old('unit_kerja') == $unit->nama ? 'selected' : '' }}>
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
                            <!-- VALUE TETAP "baru" SESUAI VALIDASI CONTROLLER -->
                            <option value="baru" {{ old('jenis_permohonan') == 'baru' ? 'selected' : '' }}>Pendaftaran Sertifikat Elektronik</option>
                            <option value="reset_passphrase" {{ old('jenis_permohonan') == 'reset_passphrase' ? 'selected' : '' }}>Reset Passphrase</option>
                            <option value="perpanjangan" {{ old('jenis_permohonan') == 'perpanjangan' ? 'selected' : '' }}>Perpanjangan Sertifikat Elektronik</option>
                            <option value="penghapusan" {{ old('jenis_permohonan') == 'penghapusan' ? 'selected' : '' }}>Penghapusan Sertifikat Elektronik</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Alasan/Keterangan</label>
                        <textarea name="keterangan" rows="1" class="w-full px-4 py-3 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-teal-500/10 outline-none font-semibold text-slate-700" required>{{ old('keterangan') }}</textarea>
                    </div>
                </div>

                <!-- KOTAK SYARAT DAN KETENTUAN -->
                <div id="sk-box" class="h-96 overflow-y-auto bg-slate-50 border-2 border-slate-200 rounded-2xl p-6 mb-4 text-sm text-slate-600 leading-relaxed shadow-inner">
                    <h2 class="text-base font-black text-teal-800 mb-2 text-center uppercase tracking-wider">Syarat dan Ketentuan Persetujuan Pemrosesan Data Pribadi</h2>
                    <p class="font-bold text-slate-800 text-center mb-4">Layanan Permohonan Tanda Tangan Elektronik (TTE)<br>Dinas Komunikasi, Informatika, Statistik, dan Persandian Kabupaten Belitung Timur</p>
                    
                    <p class="mb-4">Sebelum mengirimkan permohonan, mohon membaca Syarat dan Ketentuan berikut dengan saksama.</p>

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
                            <p class="mt-1">Data pribadi Anda tidak akan digunakan untuk tujuan lain di luar proses layanan TTE sebagaimana disebutkan di atas.</p>
                        </div>

                        <div>
                            <h3 class="font-bold text-slate-800">2. Data Pribadi yang Dikumpulkan</h3>
                            <p>Untuk memproses permohonan, kami mengumpulkan data berikut:</p>
                            <ul class="list-disc list-inside ml-2 mt-1">
                                <li>2.1. Nama lengkap;</li>
                                <li>2.2. Nomor Induk Kependudukan (NIK);</li>
                                <li>2.3. Nomor Induk Pegawai (NIP) — bersifat opsional;</li>
                                <li>2.4. Nomor WhatsApp/HP;</li>
                                <li>2.5. Jabatan saat ini;</li>
                                <li>2.6. Kategori instansi (sekolah, desa, atau Organisasi Perangkat Daerah/OPD);</li>
                                <li>2.7. Unit kerja/nama instansi;</li>
                                <li>2.8. Jenis layanan TTE yang dimohonkan; dan</li>
                                <li>2.9. Alasan/keterangan permohonan (apabila diperlukan).</li>
                            </ul>
                        </div>

                        <div>
                            <h3 class="font-bold text-slate-800">3. Kategori Pengguna Layanan</h3>
                            <p>Layanan permohonan TTE ini dapat diakses oleh pemohon dari kategori instansi berikut:</p>
                            <ul class="list-disc list-inside ml-2 mt-1">
                                <li>3.1. Sekolah;</li>
                                <li>3.2. Desa; dan</li>
                                <li>3.3. Organisasi Perangkat Daerah (OPD).</li>
                            </ul>
                        </div>

                        <div>
                            <h3 class="font-bold text-slate-800">4. Dasar Pemrosesan Data Pribadi</h3>
                            <p>Pemrosesan data pribadi Anda dilaksanakan berdasarkan persetujuan eksplisit yang Anda berikan pada saat mengirimkan formulir ini, sesuai dengan Undang-Undang Nomor 27 Tahun 2022 tentang Pelindungan Data Pribadi.</p>
                        </div>

                        <div>
                            <h3 class="font-bold text-slate-800">5. Penyimpanan Data Pribadi</h3>
                            <ul class="list-disc list-inside ml-2">
                                <li>5.1. Data pribadi Anda disimpan selama sertifikat elektronik Anda masih aktif dan/atau selama diperlukan untuk keperluan administrasi layanan TTE.</li>
                                <li>5.2. Data pribadi disimpan dengan menerapkan langkah keamanan yang memadai untuk mencegah akses, penggunaan, atau pengungkapan yang tidak sah.</li>
                            </ul>
                        </div>

                        <div>
                            <h3 class="font-bold text-slate-800">6. Perubahan Status dan Hak Penghapusan Data</h3>
                            <ul class="list-disc list-inside ml-2">
                                <li>6.1. Apabila terjadi perubahan status pemohon seperti mutasi, pensiun, atau meninggal dunia, pemohon (atau pihak yang mewakili sesuai ketentuan yang berlaku) dapat mengajukan permohonan penghapusan data dan/atau sertifikat elektronik melalui layanan ini dengan memilih jenis layanan "Penghapusan Sertifikat Elektronik".</li>
                                <li>6.2. Permohonan penghapusan akan ditindaklanjuti sesuai dengan mekanisme pemenuhan hak subjek data pribadi yang berlaku di lingkungan DiskominfoSP Kabupaten Belitung Timur, paling lambat 3 x 24 (tiga kali dua puluh empat) jam sejak permohonan diterima dan dinyatakan lengkap.</li>
                            </ul>
                        </div>

                        <div>
                            <h3 class="font-bold text-slate-800">7. Hak Subjek Data Pribadi</h3>
                            <p>Sebagai subjek data pribadi, Anda berhak untuk:</p>
                            <ul class="list-disc list-inside ml-2 mt-1">
                                <li>7.1. mendapatkan informasi yang jelas mengenai tujuan pemrosesan data pribadi Anda;</li>
                                <li>7.2. memperbaiki atau memperbarui data pribadi yang tidak akurat;</li>
                                <li>7.3. mengakses dan memperoleh salinan data pribadi Anda;</li>
                                <li>7.4. mengajukan penghapusan data pribadi sebagaimana dimaksud pada angka 6;</li>
                                <li>7.5. menarik kembali persetujuan yang telah diberikan; dan</li>
                                <li>7.6. mengajukan keberatan atau pengaduan apabila terdapat dugaan pelanggaran pemrosesan data pribadi Anda.</li>
                            </ul>
                        </div>

                        <div>
                            <h3 class="font-bold text-slate-800">8. Pengungkapan Data Pribadi</h3>
                            <ul class="list-disc list-inside ml-2">
                                <li>8.1. Data pribadi Anda tidak akan dibagikan kepada pihak ketiga di luar keperluan proses pendaftaran sertifikat elektronik, reset passphrase, perpanjangan sertifikat elektronik, dan penghapusan sertifikat elektronik, kecuali diwajibkan oleh ketentuan peraturan perundang-undangan.</li>
                                <li>8.2. Dalam hal proses pendaftaran sertifikat elektronik memerlukan verifikasi lanjutan kepada Otoritas Penyelenggara Sertifikasi Elektronik (BSrE-BSSN), data pribadi Anda dapat diteruskan sebatas keperluan verifikasi tersebut, dan tunduk pula pada Kebijakan Privasi BSrE CA yang dapat diakses melalui https://bsre.bssn.go.id.</li>
                            </ul>
                        </div>

                        <div>
                            <h3 class="font-bold text-slate-800">9. Pernyataan Persetujuan</h3>
                            <p>Dengan mencentang/mengirimkan formulir ini, Anda menyatakan bahwa:</p>
                            <ul class="list-disc list-inside ml-2 mt-1">
                                <li>9.1. data yang Anda isikan adalah benar dan dapat dipertanggungjawabkan;</li>
                                <li>9.2. Anda telah membaca, memahami, dan menyetujui Syarat dan Ketentuan ini serta memberikan persetujuan atas pemrosesan data pribadi Anda untuk keperluan layanan TTE sebagaimana dimaksud; dan</li>
                                <li>9.3. Anda menyetujui penggunaan tanda tangan elektronik sesuai ketentuan peraturan perundang-undangan yang berlaku.</li>
                            </ul>
                        </div>

                        <div>
                            <h3 class="font-bold text-slate-800">10. Kontak</h3>
                            <p>Apabila terdapat pertanyaan mengenai Syarat dan Ketentuan ini atau ingin menggunakan hak Anda sebagai subjek data pribadi, silakan menghubungi Jefri Hunter Juanda Sianturi (+62 817-0771-715), Alvin (+62 896-3656-8444), atau Febri Heryo Yudanto (+62 822-8239-8566).</p>
                        </div>
                    </div>
                </div>

                <!-- PERINGATAN SCROLL -->
                <p id="scroll-warning" class="text-xs text-red-500 text-center mb-4 font-bold animate-pulse">* Silakan baca dan scroll ke bagian bawah pada Syarat & Ketentuan di atas untuk mengaktifkan tombol kirim.</p>

                <!-- TOMBOL SUBMIT -->
                <button type="submit" id="btn-submit" disabled class="w-full bg-gradient-to-r from-slate-400 to-slate-500 text-white/50 font-black py-4 rounded-2xl shadow-xl cursor-not-allowed flex items-center justify-center gap-3 text-lg mb-8 transition-all">
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

     <div class="footer py-8 text-center text-slate-400 text-xs font-medium">
        <div class="flex justify-center items-center gap-4 mb-3">
            <a href="{{ route('kebijakan.privasi') }}" class="hover:text-teal-600 transition-colors">Kebijakan Privasi</a>
            <span class="text-slate-300">|</span>
            <a href="{{ route('syarat.ketentuan') }}" class="hover:text-teal-600 transition-colors">Syarat & Ketentuan</a>
        </div>
        <p>© {{ date('Y') }} Diskominfo Belitung Timur</p>
        <p class="mt-1 opacity-60 italic text-[10px]">Tanda Tangan Elektronik yang Sah dan Terpercaya</p>
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

        // ================= FUNGSI DETEKSI SCROLL SK & KETENTUAN =================
        const skBox = document.getElementById('sk-box');
        const btnSubmit = document.getElementById('btn-submit');
        const scrollWarning = document.getElementById('scroll-warning');

        skBox.addEventListener('scroll', function() {
            // Mendeteksi apakah scroll sudah sampai paling bawah
            const isScrolledToBottom = skBox.scrollHeight - skBox.clientHeight <= skBox.scrollTop + 20;

            if (isScrolledToBottom) {
                // Aktifkan tombol
                btnSubmit.disabled = false;
                btnSubmit.classList.remove('bg-gradient-to-r', 'from-slate-400', 'to-slate-500', 'text-white/50', 'cursor-not-allowed');
                btnSubmit.classList.add('bg-gradient-to-r', 'from-teal-700', 'to-teal-900', 'text-white', 'hover:shadow-teal-900/50', 'hover:-translate-y-1', 'shadow-teal-900/30');
                
                // Hilangkan peringatan
                scrollWarning.classList.add('hidden');
            }
        });
    });
    </script>
</body>
</html>