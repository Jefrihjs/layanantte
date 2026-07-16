<div class="modal-body p-0">
    {{-- BAR STATUS ATAS --}}
    <div style="background: #f8fafc; padding: 15px 25px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
        <span class="text-muted small fw-bold text-uppercase">Status Permohonan</span>
        @if($log->status == 'pending')
            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill shadow-sm" style="font-size: 11px; font-weight: 800;">
                <i class="fa-solid fa-clock me-1"></i> PENDING
            </span>
        @else
            <span class="badge bg-success px-3 py-2 rounded-pill shadow-sm" style="font-size: 11px; font-weight: 800;">
                <i class="fa-solid fa-check-circle me-1"></i> DIPROSES OLEH {{ strtoupper($log->admin->name ?? 'ADMIN') }}
            </span>
        @endif
    </div>

    <div class="p-4">
        <div class="row g-4">
            {{-- KOLOM KIRI: DATA PERSONAL --}}
            <div class="col-md-6">
                <div class="mb-4">
                    <label class="text-muted small fw-bold d-block mb-1 text-uppercase">
                        <i class="fa-solid fa-calendar-day me-2 text-primary"></i>Tanggal Masuk
                    </label>
                    <div class="fw-bold text-dark">{{ \Carbon\Carbon::parse($log->tanggal)->format('d-m-Y') }}</div>
                </div>
                <div class="mb-4">
                    <label class="text-muted small fw-bold d-block mb-1 text-uppercase">
                        <i class="fa-solid fa-user me-2 text-primary"></i>Nama Lengkap
                    </label>
                    <div class="fw-bold text-primary" style="font-size: 16px;">{{ $log->nama }}</div>
                </div>
                <div class="mb-4">
                    <label class="text-muted small fw-bold d-block mb-1 text-uppercase">
                        <i class="fa-solid fa-id-card me-2 text-primary"></i>NIK / NIP
                    </label>
                    <div class="text-dark fw-bold">{{ $log->nik }}</div>
                    <div class="text-muted small">{{ $log->nip ?? '-' }}</div>
                </div>
                <div class="mb-4">
                    <label class="text-muted small fw-bold d-block mb-1 text-uppercase">
                        <i class="fa-solid fa-phone me-2 text-primary"></i>Nomor WhatsApp
                    </label>
                    <div class="text-dark fw-bold">{{ $log->no_hp }}</div>
                </div>

                {{-- === RIWAYAT PERMOHONAN === --}}
                <div class="mb-0">
                    <label class="text-muted small fw-bold d-block mb-2 text-uppercase">
                        <i class="fa-solid fa-clock-rotate-left me-2 text-warning"></i>Riwayat Permohonan
                    </label>
                    
                    @php
                        $riwayatPermohonan = $log->riwayatPermohonan->sortByDesc('tanggal');
                        $totalPermohonan = $riwayatPermohonan->count();
                    @endphp

                    @if($totalPermohonan > 1)
                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill shadow-sm mb-2" style="font-size: 11px; font-weight: 800;">
                            <i class="fa-solid fa-triangle-exclamation me-1"></i> PEMOHON SUDAH {{ $totalPermohonan }}x MENGAJUKAN LAYANAN
                        </span>
                        <div class="mt-2 p-2 border-start border-warning border-3" style="background-color: #fffbeb; border-radius: 0 8px 8px 0;">
                            <ul class="list-unstyled mb-0 small">
                                @foreach($riwayatPermohonan as $riwayat)
                                    <li class="mb-1 {{ $loop->first ? 'fw-bold text-dark' : 'text-muted' }}">
                                        <span class="text-capitalize">
                                            @if($riwayat->jenis_permohonan == 'baru') Pendaftaran Sertifikat Elektronik
                                            @elseif($riwayat->jenis_permohonan == 'reset_passphrase') Reset Passphrase
                                            @elseif($riwayat->jenis_permohonan == 'perpanjangan') Perpanjangan Sertifikat Elektronik
                                            @elseif($riwayat->jenis_permohonan == 'penghapusan') Penghapusan Sertifikat Elektronik
                                            @elseif($riwayat->jenis_permohonan == 'lapor_kendala') Lapor Kendala TTE
                                            @endif
                                        </span> 
                                        <span class="text-secondary">({{ \Carbon\Carbon::parse($riwayat->tanggal)->format('d-m-Y') }})</span>
                                        @if($riwayat->status == 'pending')
                                            <span class="badge bg-warning text-dark" style="font-size:9px;">Pending</span>
                                        @else
                                            <span class="badge bg-success" style="font-size:9px;">Diproses</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @elseif($totalPermohonan == 1)
                        <span class="badge bg-success px-3 py-2 rounded-pill shadow-sm" style="font-size: 11px; font-weight: 800;">
                            <i class="fa-solid fa-check me-1"></i> PERMOHONAN PERTAMA KALI
                        </span>
                    @endif
                </div>
                {{-- === END RIWAYAT PERMOHONAN === --}}
            </div>

            {{-- KOLOM KANAN: DATA KERJA --}}
            <div class="col-md-6">
                <div class="mb-4">
                    <label class="text-muted small fw-bold d-block mb-1 text-uppercase">
                        <i class="fa-solid fa-briefcase me-2 text-primary"></i>Jabatan
                    </label>
                    <div class="text-dark fw-bold">{{ $log->jabatan }}</div>
                </div>
                <div class="mb-4">
                    <label class="text-muted small fw-bold d-block mb-1 text-uppercase">
                        <i class="fa-solid fa-building me-2 text-primary"></i>Unit Kerja
                    </label>
                    <div class="text-dark fw-medium" style="line-height: 1.4;">{{ $log->unit_kerja }}</div>
                </div>
                <div class="mb-4">
                    <label class="text-muted small fw-bold d-block mb-1 text-uppercase">
                        <i class="fa-solid fa-tag me-2 text-primary"></i>Jenis Permohonan
                    </label>
                    <br>
                    <span class="badge bg-info text-dark fw-bold px-3 py-2 rounded-pill mt-1" style="font-size: 10px;">
                        @if($log->jenis_permohonan == 'baru') Pendaftaran Sertifikat Elektronik
                        @elseif($log->jenis_permohonan == 'reset_passphrase') Reset Passphrase
                        @elseif($log->jenis_permohonan == 'perpanjangan') Perpanjangan Sertifikat Elektronik
                        @elseif($log->jenis_permohonan == 'penghapusan') Penghapusan Sertifikat Elektronik
                        @elseif($log->jenis_permohonan == 'lapor_kendala') Lapor Kendala TTE
                        @endif
                    </span>
                </div>
            </div>

            {{-- KETERANGAN (PENUH) --}}
            <div class="col-12">
                <div style="background: #f1f5f9; padding: 20px; border-radius: 15px; border-left: 5px solid #0f766e;">
                    <label class="text-muted small fw-bold d-block mb-2 text-uppercase">
                        <i class="fa-solid fa-comment-dots me-2 text-primary"></i>Keterangan Pemohon
                    </label>
                    <div class="text-dark" style="font-style: italic;">
                        "{{ $log->keterangan ?? 'Tidak ada keterangan tambahan.' }}"
                    </div>
                </div>
            </div>

            {{-- FORM INPUT EMAIL UNTUK PROSES WA (HANYA JIKA PENDING) --}}
            @if($log->status == 'pending')
            <div class="col-12 mt-2">
                <form method="POST" action="{{ route('admin.permohonan.proses', $log->id) }}" id="formProsesWA" target="_blank" onsubmit="setTimeout(function(){ window.location.reload(); }, 1500);">
                    @csrf
                    <div style="background: #e0f2fe; padding: 20px; border-radius: 15px; border-left: 5px solid #0284c7;">
                        <label class="text-dark small fw-bold d-block mb-1 text-uppercase">
                            <i class="fa-solid fa-envelope me-2" style="color: #0284c7;"></i>Input Email Pemohon (Untuk Kirim WA)
                        </label>
                        <p class="text-muted small mb-3">Sistem akan mengarahkan Anda ke WhatsApp untuk mengirim detail permohonan ke nomor <strong>{{ $log->no_hp }}</strong>.</p>
                        
                        <input type="email" name="email" class="form-control" required 
                            placeholder="contoh: nama.pegawai@beltim.go.id" 
                            value="{{ $log->email ?? '' }}" 
                            style="border-radius: 10px; border: 1px solid #bae6fd;">
                    </div>
                </form>

                {{-- FORM PROSES SAJA (TANPA WA) --}}
                <form method="POST" action="{{ route('admin.permohonan.proses', $log->id) }}" id="formProsesSaja">
                    @csrf
                    <input type="hidden" name="proses_saja" value="true">
                </form>
            </div>
            @endif

        </div>
    </div>

        @if($log->jenis_permohonan == 'lapor_kendala' && $log->bukti_kendala)
        <div class="col-12 mt-2">
            <div style="background: #fef2f2; padding: 20px; border-radius: 15px; border-left: 5px solid #dc2626;">
                <label class="text-muted small fw-bold d-block mb-2 text-uppercase">
                    <i class="fa-solid fa-image me-2 text-danger"></i>Bukti Kendala
                </label>
                
                @php
                    // Cek apakah file ini PDF atau Gambar
                    $extension = pathinfo($log->bukti_kendala, PATHINFO_EXTENSION);
                @endphp

                @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                    <!-- Jika Gambar, tampilkan thumbnail -->
                    <a href="{{ asset('storage/bukti_kendala/' . $log->bukti_kendala) }}" target="_blank">
                        <img src="{{ asset('storage/bukti_kendala/' . $log->bukti_kendala) }}" 
                            alt="Bukti Kendala" 
                            class="img-fluid rounded shadow-sm border" 
                            style="max-height: 200px; width: 100%; object-fit: cover;">
                    </a>
                @else
                    <!-- Jika PDF, tampilkan tombol download/lihat -->
                    <a href="{{ asset('storage/bukti_kendala/' . $log->bukti_kendala) }}" target="_blank" class="btn btn-danger btn-sm rounded-pill fw-bold">
                        <i class="fa-solid fa-file-pdf me-1"></i> Lihat Dokumen PDF
                    </a>
                @endif
                
            </div>
        </div>
        @endif

    </div>
    {{-- TOMBOL AKSI DI BAWAH --}}
    <div class="modal-footer border-0 bg-light p-3">
        <button type="button" class="btn btn-secondary btn-sm px-4 rounded-pill fw-bold" data-bs-dismiss="modal">Tutup</button>
        
        @if($log->status == 'pending')
            <button type="submit" form="formProsesSaja" class="btn btn-outline-success btn-sm px-4 rounded-pill fw-bold shadow-sm">
                <i class="fa-solid fa-check me-2"></i> Proses Saja
            </button>
            <button type="submit" form="formProsesWA" class="btn btn-primary btn-sm px-4 rounded-pill fw-bold shadow-sm" style="background: #0f766e; border: none;">
                <i class="fa-brands fa-whatsapp me-2" style="font-size: 16px;"></i> Proses & Kirim WA
            </button>
        @else
            <form method="POST" action="{{ route('admin.permohonan.proses', $log->id) }}" id="formKirimUlang_{{ $log->id }}" target="_blank">
                @csrf
                <input type="hidden" name="email" value="{{ $log->email }}">
                
                <button type="button" onclick="konfirmasiKirimUlang({{ $log->id }})" class="btn btn-outline-success btn-sm px-4 rounded-pill fw-bold shadow-sm">
                    <i class="fa-brands fa-whatsapp me-2" style="font-size: 16px;"></i> Kirim Ulang WA
                </button>
            </form>
        @endif
    </div>
</div>

<script>
    function konfirmasiKirimUlang(formId) {
        Swal.fire({
            title: 'Kirim Ulang Pesan WA?',
            text: "Pesan WA sudah pernah terkirim sebelumnya. Apakah Anda yakin ingin mengirim ulang pesan ini?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0f766e',
            cancelButtonColor: '#d33',
            confirmButtonText: '<i class="fa-brands fa-whatsapp me-1"></i> Ya, Kirim Ulang!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('formKirimUlang_' + formId).submit();
            }
        });
    }
</script>