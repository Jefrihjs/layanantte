@extends('layouts.app')

@section('content')

<div class="page-container">

    <div class="page-header-flex">
        <div>
            <h2>Edit Permohonan</h2>
            <span class="page-subtitle">
                Perbarui data permohonan
            </span>
        </div>
    </div>

    <div class="form-card">

        <form method="POST" action="{{ route('permohonan.update', $log->id) }}">
            @csrf
            @method('PUT')

            <div class="form-grid">

                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama"
                           value="{{ old('nama', $log->nama) }}" required>
                </div>

                <div class="form-group">
                    <label>NIK</label>
                    <input type="text" value="{{ $log->nik }}" disabled>
                </div>

                <div class="form-group">
                    <label>NIP</label>
                    <input type="text" value="{{ $log->nip }}" disabled>
                </div>

                <div class="form-group">
                    <label>No HP</label>
                    <input type="text" name="no_hp"
                           value="{{ old('no_hp', $log->no_hp) }}" required>
                </div>

                <div class="form-group">
                    <label>Jabatan</label>
                    <input type="text" name="jabatan"
                           value="{{ old('jabatan', $log->jabatan) }}" required>
                </div>

                <div class="form-group full-width">
                    <label>Keterangan</label>
                    <textarea name="keterangan" rows="3" required>
{{ old('keterangan', $log->keterangan) }}
                    </textarea>
                </div>

            </div>

            <div class="form-actions">
                <a href="{{ route('permohonan.index') }}" class="btn-secondary">
                    Batal
                </a>

                <button type="submit" class="btn-primary">
                    Simpan Perubahan
                </button>
            </div>

        </form>

    </div>

</div>

@endsection