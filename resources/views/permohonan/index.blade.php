@extends('layouts.app')

@section('page_title', 'Daftar Permohonan TTE')

@section('content')
<style>
    /* Tambahan agar tampilan tabel lebih premium */
    .table thead th {
        background-color: #f8fafc;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 1px;
        color: #64748b;
        padding: 15px 10px;
        border-top: none;
    }
    .table tbody td {
        padding: 15px 10px;
        vertical-align: middle;
        border-color: #f1f5f9;
    }
    .badge-status {
        font-size: 11px;
        font-weight: 700;
        padding: 6px 12px;
        border-radius: 50px;
        text-transform: uppercase;
    }
    .filter-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 15px;
    }
    .btn-action {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: 0.2s;
    }
    .btn-action:hover {
        transform: scale(1.1);
    }
</style>

<div class="container-fluid p-0">
    
    {{-- AREA HEADER & EXPORT --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1 text-dark">Data Permohonan</h4>
            <p class="text-muted small mb-0">Total ditemukan: <strong>{{ $data->total() }}</strong> data permohonan</p>
        </div>
        <a href="{{ route('permohonan.export', request()->query()) }}" class="btn btn-success rounded-pill px-4 shadow-sm fw-bold border-0">
            <i class="fa-solid fa-file-excel me-2"></i> Export Excel
        </a>
    </div>

    {{-- AREA FILTER --}}
    <div class="card filter-card shadow-sm mb-4">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('permohonan.index') }}" class="row g-3">
                {{-- Cari Nama --}}
                <div class="col-md-3">
                    <label class="small fw-bold text-muted mb-1">Cari Nama/NIK</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control border-start-0 ps-0" placeholder="Ketik di sini...">
                    </div>
                </div>

                {{-- Filter Tahun --}}
                <div class="col-md-2">
                    <label class="small fw-bold text-muted mb-1">Tahun</label>
                    <select name="tahun" class="form-select form-select-sm shadow-none">
                        <option value="">Semua Tahun</option>
                        @for($i = date('Y'); $i >= 2024; $i--)
                            <option value="{{ $i }}" {{ request('tahun', date('Y')) == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                {{-- FILTER TRIWULAN (BARU) --}}
                <div class="col-md-2">
                    <label class="small fw-bold text-muted mb-1">Periode Triwulan</label>
                    <select name="triwulan" class="form-select form-select-sm shadow-none">
                        <option value="">Setahun Penuh</option>
                        <option value="1" {{ request('triwulan') == '1' ? 'selected' : '' }}>Triwulan I (Jan-Mar)</option>
                        <option value="2" {{ request('triwulan') == '2' ? 'selected' : '' }}>Triwulan II (Apr-Jun)</option>
                        <option value="3" {{ request('triwulan') == '3' ? 'selected' : '' }}>Triwulan III (Jul-Sep)</option>
                        <option value="4" {{ request('triwulan') == '4' ? 'selected' : '' }}>Triwulan IV (Okt-Des)</option>
                    </select>
                </div>

                {{-- Jenis Layanan --}}
                <div class="col-md-2">
                    <label class="small fw-bold text-muted mb-1">Jenis Layanan</label>
                    <select name="jenis" class="form-select form-select-sm shadow-none">
                        <option value="">Semua Jenis</option>
                        <option value="baru" {{ request('jenis') == 'baru' ? 'selected' : '' }}>Pendaftaran Baru</option>
                        <option value="reset_passphrase" {{ request('jenis') == 'reset_passphrase' ? 'selected' : '' }}>Reset Passphrase</option>
                    </select>
                </div>

                {{-- Tombol Aksi --}}
                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4 fw-bold w-100 shadow-sm">
                        <i class="fa-solid fa-filter me-1"></i> Filter
                    </button>
                    <a href="{{ route('permohonan.index') }}" class="btn btn-light btn-sm rounded-pill px-4 fw-bold w-100 border text-muted">
                        <i class="fa-solid fa-rotate-left me-1"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- TABEL DATA --}}
    <div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Tanggal Masuk</th>
                        <th>Identitas Pemohon</th>
                        <th>Unit Kerja</th>
                        <th>Jenis Layanan</th>
                        <th class="text-center">Status</th>
                        <th class="text-center pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $item)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark">{{ $item->created_at->format('d M Y') }}</div>
                                <small class="text-muted">{{ $item->created_at->format('H:i') }} WIB</small>
                            </td>
                            <td>
                                <div class="fw-bold text-primary">{{ $item->nama }}</div>
                                <div class="text-muted small" style="letter-spacing: 0.5px;">NIK: {{ $item->nik }}</div>
                            </td>
                            <td>
                                <div class="small text-dark fw-medium" style="max-width: 200px; line-height: 1.4;">{{ $item->unit_kerja }}</div>
                            </td>
                            <td>
                                @php
                                    $jenis_label = $item->jenis_permohonan == 'baru' ? 'Pendaftaran Baru' : ($item->jenis_permohonan == 'reset_passphrase' ? 'Reset Passphrase' : 'Perpanjangan');
                                    $jenis_color = $item->jenis_permohonan == 'baru' ? 'bg-primary' : 'bg-info text-dark';
                                @endphp
                                <span class="badge {{ $jenis_color }} bg-opacity-10 text-{{ explode(' ', $jenis_color)[0] == 'bg-primary' ? 'primary' : 'dark' }} small border-0 fw-bold px-3 py-2" style="font-size: 10px;">
                                    {{ $jenis_label }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if($item->status == 'diproses')
                                    <span class="badge-status bg-success bg-opacity-10 text-success border border-success border-opacity-25">
                                        <i class="fa-solid fa-circle-check me-1 small"></i> Diproses
                                    </span>
                                @else
                                    <span class="badge-status bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25" style="color: #d97706 !important;">
                                        <i class="fa-solid fa-clock me-1 small"></i> Pending
                                    </span>
                                @endif
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-1">
                                    <button onclick="showDetail('{{ route('permohonan.detail', $item->id) }}')" 
                                            class="btn btn-action btn-light border text-primary" title="Lihat Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                    
                                    <a href="{{ route('permohonan.edit', $item->id) }}" 
                                       class="btn btn-action btn-light border text-warning" title="Edit Data">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    
                                    <form action="{{ route('permohonan.destroy', $item->id) }}" method="POST" class="d-inline form-hapus">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="button" class="btn btn-action btn-light border text-danger btn-delete" title="Hapus">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                {{-- Ganti SVG yang mati dengan Ikon FontAwesome --}}
                                <div class="mb-3">
                                    <i class="fa-solid fa-folder-open text-light" style="font-size: 80px; color: #e2e8f0 !important;"></i>
                                </div>
                                <h6 class="fw-bold text-muted">Data permohonan tidak ditemukan.</h6>
                                <p class="text-small text-muted">Coba sesuaikan filter atau kata kunci pencarian</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- PAGINATION --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $data->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>

</div>

<div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none; overflow: hidden;">
            <div class="modal-header border-0 p-4" style="background: #0f766e; color: white;">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-file-lines me-2"></i> Detail Permohonan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0" id="detailContent">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Mengambil data...</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function(e) {
            const form = this.closest('.form-hapus');
            
            Swal.fire({
                title: 'Yakin hapus data?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0f766e', // Warna Teal
                cancelButtonColor: '#64748b', // Warna Abu-abu
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                border: 'none',
                borderRadius: '15px'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // Bonus: Munculkan notifikasi jika berhasil hapus
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 1500
        });
    @endif
</script>

<script>
    function showDetail(url) {
        // 1. Tampilkan Modal
        const myModal = new bootstrap.Modal(document.getElementById('modalDetail'));
        myModal.show();

        // 2. Reset konten ke loading spinner
        document.getElementById('detailContent').innerHTML = `
            <div class="text-center py-5">
                <div class="spinner-border text-teal" role="status" style="color: #0f766e;"></div>
                <p class="mt-2 text-muted small fw-bold">MEMUAT DATA...</p>
            </div>
        `;

        // 3. Ambil data pakai Fetch API (AJAX)
        fetch(url)
            .then(response => response.text())
            .then(html => {
                document.getElementById('detailContent').innerHTML = html;
            })
            .catch(error => {
                document.getElementById('detailContent').innerHTML = `
                    <div class="alert alert-danger m-3">Gagal mengambil data. Silakan coba lagi.</div>
                `;
            });
    }
</script>
@endpush