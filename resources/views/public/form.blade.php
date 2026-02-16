<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Permohonan TTE</title>
    <link rel="stylesheet" href="{{ asset('css/public.css') }}">
</head>
<body>

<div class="top-bar"></div>

<div class="wrapper">

    <div class="card">

        <div class="logo-inside">
            <img src="{{ asset('img/logo-beltim.png') }}" alt="Logo Beltim">
        </div>

        <h1>Form Permohonan Layanan TTE</h1>

        <form method="POST" action="{{ route('tte.store') }}">
            @csrf

            <input type="hidden" name="tanggal" value="{{ now()->format('Y-m-d') }}">

            <div class="grid-2">

                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control"
                           value="{{ $last->nama ?? '' }}" required>
                </div>

                <div class="form-group">
                    <label>NIK</label>
                    <input type="text" name="nik" class="form-control"
                           value="{{ $nik }}" readonly>
                </div>

                <div class="form-group">
                    <label>NIP (Opsional)</label>
                    <input type="text" name="nip" class="form-control"
                           value="{{ $last->nip ?? '' }}">
                </div>

                <div class="form-group">
                    <label>No HP</label>
                    <input type="text" name="no_hp" class="form-control"
                           value="{{ $last->no_hp ?? '' }}" required>
                </div>

                <div class="form-group">
                    <label>Jabatan</label>
                    <input type="text" name="jabatan" class="form-control"
                           value="{{ $last->jabatan ?? '' }}" required>
                </div>

                <div class="form-group">
                    <label>Unit Kerja</label>
                    <input type="text" name="unit_kerja" class="form-control"
                           value="{{ $last->unit_kerja ?? '' }}" required>
                </div>

            </div>

            <div class="form-group">
                <label>Jenis Permohonan</label>
                <select name="jenis_permohonan"
                     class="form-control @error('jenis_permohonan') input-error @enderror"
                     required>

              <option value="">-- Pilih Jenis Permohonan --</option>
              <option value="baru" {{ old('jenis_permohonan') == 'baru' ? 'selected' : '' }}>
                     Pendaftaran Baru
              </option>
              <option value="reset_passphrase" {{ old('jenis_permohonan') == 'reset_passphrase' ? 'selected' : '' }}>
                     Reset Passphrase
              </option>
              <option value="perpanjangan" {{ old('jenis_permohonan') == 'perpanjangan' ? 'selected' : '' }}>
                     Perpanjangan Sertifikat
              </option>
              </select>
            </div>

            <div class="form-group">
                <label>Keterangan</label>
                <textarea name="keterangan" class="form-control"
                          rows="4" required></textarea>
            </div>

            <button type="submit" class="btn">
                Simpan Permohonan
            </button>

        </form>

    </div>

</div>

<div class="footer">
    © {{ date('Y') }} Pemerintah Kabupaten Belitung Timur
</div>

</body>
</html>
