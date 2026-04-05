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
                <div class="mb-0">
                    <label class="text-muted small fw-bold d-block mb-1 text-uppercase">
                        <i class="fa-solid fa-phone me-2 text-primary"></i>Nomor WhatsApp
                    </label>
                    <div class="text-dark fw-bold">{{ $log->no_hp }}</div>
                </div>
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
                    <span class="badge bg-info text-dark fw-bold px-3 py-2 rounded-pill" style="font-size: 10px;">
                        @if($log->jenis_permohonan == 'reset_passphrase') 
                            Reset Passphrase
                        @elseif($log->jenis_permohonan == 'perpanjangan') 
                            Perpanjangan Sertifikat
                        @else 
                            Pendaftaran Baru 
                        @endif
                    </span>
                </div>
            </div>

            {{-- KETERANGAN (PENUH) --}}
            <div class="col-12">
                <div style="background: #f1f5f9; padding: 20px; border-radius: 15px; border-left: 5px solid #0f766e;">
                    <label class="text-muted small fw-bold d-block mb-2 text-uppercase">
                        <i class="fa-solid fa-comment-dots me-2 text-primary"></i>Keterangan Admin
                    </label>
                    <div class="text-dark" style="font-style: italic;">
                        "{{ $log->keterangan ?? 'Tidak ada keterangan tambahan.' }}"
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TOMBOL AKSI DI BAWAH --}}
    <div class="modal-footer border-0 bg-light p-3">
        <button type="button" class="btn btn-secondary btn-sm px-4 rounded-pill fw-bold" data-bs-dismiss="modal">Tutup</button>
        
        @if($log->status == 'pending')
            <form method="POST" action="{{ route('permohonan.proses', $log->id) }}" class="m-0">
                @csrf
                <button type="submit" class="btn btn-primary btn-sm px-4 rounded-pill fw-bold shadow-sm" style="background: #0f766e; border: none;">
                    <i class="fa-solid fa-check me-2"></i> Proses Permohonan Sekarang
                </button>
            </form>
        @endif
    </div>
</div>