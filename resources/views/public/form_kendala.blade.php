<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Lapor Kendala TTE | Kab. Belitung Timur</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f1f5f9; }
        .select2-container--default .select2-selection--single {
            border: 2px solid #f1f5f9 !important; border-radius: 1rem !important; height: 52px !important; padding: 10px !important; background-color: #f8fafc !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow { height: 50px !important; }
        
        /* Animasi Drag Over */
        .drag-over { border-color: #dc2626 !important; background-color: #fef2f2 !important; transform: scale(1.02); }
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

                    <!-- UNGGAH BUKTI INTERAKTIF -->
                    <div class="form-group">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Unggah Bukti Kendala - <span class="text-slate-300 normal-case">Opsional</span></label>
                        
                        <!-- Area Drag & Drop -->
                        <div id="dropZone" class="flex flex-col items-center justify-center w-full h-52 border-2 border-slate-200 border-dashed rounded-2xl cursor-pointer bg-slate-50 hover:bg-slate-100 transition-all relative overflow-hidden">
                            
                            <!-- Hidden Input File -->
                            <input id="bukti_kendala" name="bukti_kendala" type="file" class="hidden" accept="image/*,application/pdf">
                            
                            <!-- Tampilan Default -->
                            <div id="defaultContent" class="flex flex-col items-center justify-center pt-5 pb-6 text-center z-10 pointer-events-none">
                                <i class="fa-solid fa-cloud-arrow-up text-4xl text-slate-400 mb-3"></i>
                                <p class="text-sm text-slate-600 font-bold">Tarik & Lepas file di sini</p>
                                <p class="text-xs text-slate-400 mb-4">atau tekan <kbd class="bg-slate-200 px-1.5 py-0.5 rounded text-[10px] font-bold">Ctrl+V</kbd> untuk paste screenshot</p>
                                <div class="flex gap-2 pointer-events-auto">
                                    <button type="button" id="btnPilihFile" class="bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-bold py-2 px-4 rounded-lg transition-colors">
                                        <i class="fa-solid fa-folder-open mr-1"></i> Pilih File
                                    </button>
                                    <button type="button" id="btnKamera" class="bg-red-100 hover:bg-red-200 text-red-700 text-xs font-bold py-2 px-4 rounded-lg transition-colors">
                                        <i class="fa-solid fa-camera mr-1"></i> Buka Kamera
                                    </button>
                                </div>
                                <p class="text-[10px] text-slate-400 mt-3">PNG, JPG, atau PDF (Max. 2MB)</p>
                            </div>

                            <!-- Tampilan Preview Gambar -->
                            <img id="imagePreview" class="absolute inset-0 w-full h-full object-contain hidden p-2 bg-white" alt="Preview">
                            
                            <!-- Tombol Hapus File -->
                            <button type="button" id="btnHapus" class="hidden absolute top-3 right-3 bg-red-500 hover:bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center shadow-lg z-20 transition-colors">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>

                        <!-- Area Kamera Tersembunyi -->
                        <div id="cameraContainer" class="hidden mt-4 p-4 bg-slate-900 rounded-2xl">
                            <video id="video" class="w-full h-auto rounded-xl" autoplay playsinline></video>
                            <div class="flex justify-center gap-2 mt-3 flex-wrap">
                                <button type="button" id="btnCapture" class="bg-blue-500 hover:bg-blue-600 text-white text-xs font-bold py-2 px-6 rounded-lg">
                                    <i class="fa-solid fa-camera mr-1"></i> Ambil Foto
                                </button>
                                <button type="button" id="btnSwitchCamera" class="bg-slate-500 hover:bg-slate-600 text-white text-xs font-bold py-2 px-6 rounded-lg">
                                    <i class="fa-solid fa-camera-rotate mr-1"></i> Balik Kamera
                                </button>
                                <button type="button" id="btnCloseCamera" class="bg-red-500 hover:bg-red-600 text-white text-xs font-bold py-2 px-6 rounded-lg">
                                    Tutup Kamera
                                </button>
                            </div>
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
    
    <!-- JS SELECT2 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <!-- JS UPLOAD INTERAKTIF -->
    <script>
        $(document).ready(function() {
            $('#unitKerjaSelect').select2({
                placeholder: "Ketik untuk mencari unit kerja...",
                width: '100%',
                allowClear: true
            });
        });

        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('bukti_kendala');
        const defaultContent = document.getElementById('defaultContent');
        const imagePreview = document.getElementById('imagePreview');
        const fileName = document.getElementById('file-name');
        const btnHapus = document.getElementById('btnHapus');
        const btnPilihFile = document.getElementById('btnPilihFile');
        const btnKamera = document.getElementById('btnKamera');
        
        // Elemen Kamera
        const cameraContainer = document.getElementById('cameraContainer');
        const video = document.getElementById('video');
        const btnCapture = document.getElementById('btnCapture');
        const btnCloseCamera = document.getElementById('btnCloseCamera');
        const btnSwitchCamera = document.getElementById('btnSwitchCamera');
        let stream = null;
        let currentFacingMode = "environment"; // Default kamera belakang

        // Fungsi Handle File
        function handleFile(file) {
            if (file) {
                if (file.size > 2048 * 1024) {
                    alert('Ukuran file maksimal 2MB!');
                    return;
                }
                
                // Masukkan file ke input
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                fileInput.files = dataTransfer.files;

                // Update UI
                fileName.textContent = file.name;
                btnHapus.classList.remove('hidden');
                
                if (file.type.match('image.*')) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        imagePreview.src = e.target.result;
                        imagePreview.classList.remove('hidden');
                        defaultContent.classList.add('hidden');
                    };
                    reader.readAsDataURL(file);
                } else {
                    // Jika PDF
                    imagePreview.classList.add('hidden');
                    defaultContent.classList.remove('hidden');
                    defaultContent.innerHTML = `<i class="fa-solid fa-file-pdf text-4xl text-red-500 mb-3"></i><p class="text-sm text-slate-600 font-bold">File PDF Terpilih</p><p class="text-xs text-slate-400 mt-1">${file.name}</p>`;
                }
            }
        }

        // Klik untuk pilih file
        btnPilihFile.addEventListener('click', (e) => { e.stopPropagation(); fileInput.click(); });
        dropZone.addEventListener('click', () => fileInput.click());

        fileInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) handleFile(e.target.files[0]);
        });

        // Drag & Drop
        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, (e) => {
                e.preventDefault();
                dropZone.classList.add('drag-over');
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, (e) => {
                e.preventDefault();
                dropZone.classList.remove('drag-over');
            });
        });

        dropZone.addEventListener('drop', (e) => {
            if (e.dataTransfer.files.length > 0) {
                handleFile(e.dataTransfer.files[0]);
            }
        });

        // Paste (Ctrl+V)
        document.addEventListener('paste', (e) => {
            const items = (e.clipboardData || window.clipboardData).items;
            for (let item of items) {
                if (item.type.indexOf('image') !== -1) {
                    const file = item.getAsFile();
                    handleFile(file);
                    break;
                }
            }
        });

        // Hapus File
        btnHapus.addEventListener('click', (e) => {
            e.stopPropagation();
            fileInput.value = '';
            fileName.textContent = 'Tidak ada file dipilih';
            imagePreview.src = '';
            imagePreview.classList.add('hidden');
            btnHapus.classList.add('hidden');
            
            // Kembalikan defaultContent seperti semula
            defaultContent.innerHTML = `<i class="fa-solid fa-cloud-arrow-up text-4xl text-slate-400 mb-3"></i><p class="text-sm text-slate-600 font-bold">Tarik & Lepas file di sini</p><p class="text-xs text-slate-400 mb-4">atau tekan <kbd class="bg-slate-200 px-1.5 py-0.5 rounded text-[10px] font-bold">Ctrl+V</kbd> untuk paste screenshot</p><div class="flex gap-2 pointer-events-auto"><button type="button" id="btnPilihFile" class="bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-bold py-2 px-4 rounded-lg transition-colors"><i class="fa-solid fa-folder-open mr-1"></i> Pilih File</button><button type="button" id="btnKamera" class="bg-red-100 hover:bg-red-200 text-red-700 text-xs font-bold py-2 px-4 rounded-lg transition-colors"><i class="fa-solid fa-camera mr-1"></i> Buka Kamera</button></div><p class="text-[10px] text-slate-400 mt-3">PNG, JPG, atau PDF (Max. 2MB)</p>`;
            
            // Re-attach event listeners untuk tombol yang baru dibuat
            document.getElementById('btnPilihFile').addEventListener('click', (ev) => { ev.stopPropagation(); fileInput.click(); });
            document.getElementById('btnKamera').addEventListener('click', (ev) => { ev.stopPropagation(); bukaKamera(); });
        });

        // ================= LOGIKA KAMERA =================
        async function bukaKamera() {
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                try {
                    // Hentikan stream lama jika ada
                    if (stream) {
                        stream.getTracks().forEach(track => track.stop());
                    }
                    
                    // Minta akses kamera dengan facingMode saat ini
                    stream = await navigator.mediaDevices.getUserMedia({ 
                        video: { facingMode: { ideal: currentFacingMode } } 
                    });
                    
                    video.srcObject = stream;
                    cameraContainer.classList.remove('hidden');
                } catch (err) {
                    alert('Tidak dapat mengakses kamera. Pastikan browser memiliki izin untuk menggunakan kamera.');
                }
            } else {
                alert('Browser Anda tidak mendukung fitur kamera.');
            }
        }

        btnKamera.addEventListener('click', (e) => { e.stopPropagation(); bukaKamera(); });

        // Fungsi Balik Kamera
        btnSwitchCamera.addEventListener('click', () => {
            // Toggle antara kamera belakang (environment) dan depan (user)
            currentFacingMode = currentFacingMode === "environment" ? "user" : "environment";
            bukaKamera();
        });

        // Ambil Foto
        btnCapture.addEventListener('click', () => {
            const canvas = document.createElement('canvas');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            const context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            
            canvas.toBlob((blob) => {
                const file = new File([blob], "bukti-kamera.png", { type: "image/png" });
                handleFile(file);
                tutupKamera();
            }, 'image/png');
        });

        btnCloseCamera.addEventListener('click', tutupKamera);

        function tutupKamera() {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
            cameraContainer.classList.add('hidden');
        }
    </script>
</body>
</html>