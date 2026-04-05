@extends('layouts.app')

@section('page_title', 'Edit Permohonan TTE')

@section('content')
<style>
    .form-card-edit {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
    }
    .form-label-custom {
        font-size: 13px;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .form-control-custom {
        border-radius: 12px;
        padding: 12px 15px;
        border: 2px solid #f1f5f9;
        background-color: #f8fafc;
        transition: all 0.3s ease;
    }
    .form-control-custom:focus {
        border-color: #0f766e;
        background-color: #fff;
        box-shadow: 0 0 0 4px rgba(15, 118, 110, 0.1);
    }
    .form-control-custom:disabled {
        background-color: #e2e8f0;
        cursor: not-allowed;
    }
    .btn-save {
        background: linear-gradient(135deg, #0f766e 0%, #115e59 100%);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 12px;
        font-weight: 700;
        transition: 0.3s;
    }
    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(15, 118, 110, 0.3);
        color: white;
    }
    .section-title {
        font-size: 16px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .section-title::after {
        content: "";
        flex: 1;
        height: 1px;
        background: #e2e8f0;
    }
</style>

<div class="container-fluid p-0">
    
    {{-- HEADER AREA --}}
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('permohonan.index') }}" class="btn btn-light rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
            <i class="fa-solid fa-arrow-left text-muted"></i>
        </a>
        <div>
            <h4 class="fw-bold mb-0 text-dark">Edit Permohonan</h4>
            <p class="text-muted small mb-0">ID Permohonan: #{{ $log->id }}</p>
        </div>
    </div>

    <div class="card form-card-edit border-0">
        <div class="card-body p-5">
            
            <form method="POST" action="{{ route('permohonan.update', $log->id) }}">
                @csrf
                @method('PUT')

                {{-- INFORMASI IDENTITAS (READ-ONLY) --}}
                <div class="section-title">
                    <i class="fa-solid fa-id-card text-teal"></i> Identitas Utama
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom">NIK Pemohon</label>
                        <input type="text" class="form-control form-control-custom" value="{{ $log->nik }}" disabled>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom">NIP Pemohon</label>
                        <input type="text" class="form-control form-control-custom" value="{{ $log->nip }}" disabled>
                    </div>
                </div>

                {{-- INFORMASI YANG BISA DIUBAH --}}
                <div class="section-title">
                    <i class="fa-solid fa-pen-to-square text-teal"></i> Perbarui Data
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label-custom">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control form-control-custom @error('nama') is-invalid @enderror" 
                                   value="{{ old('nama', $log->nama) }}" required>
                            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label-custom">Nomor WhatsApp/HP</label>
                            <input type="text" name="no_hp" class="form-control form-control-custom @error('no_hp') is-invalid @enderror" 
                                   value="{{ old('no_hp', $log->no_hp) }}" required>
                            @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label-custom">Jabatan / Unit Kerja</label>
                            <input type="text" name="jabatan" class="form-control form-control-custom @error('jabatan') is-invalid @enderror" 
                                   value="{{ old('jabatan', $log->jabatan) }}" required>
                            @error('jabatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label-custom">Keterangan Tambahan</label>
                            <textarea name="keterangan" class="form-control form-control-custom @error('keterangan') is-invalid @enderror" 
                                      rows="4" required>{{ old('keterangan', $log->keterangan) }}</textarea>
                            @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                {{-- ACTION BUTTONS --}}
                <div class="d-flex justify-content-end gap-2 mt-5 pt-4 border-top">
                    <a href="{{ route('permohonan.index') }}" class="btn btn-light rounded-pill px-4 fw-bold text-muted border">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-save rounded-pill shadow-sm">
                        <i class="fa-solid fa-floppy-disk me-2"></i> Simpan Perubahan
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection