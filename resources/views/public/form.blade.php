<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Permohonan TTE</title>
    <link rel="stylesheet" href="{{ asset('css/public.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
<body>

<div class="top-bar"></div>

<div class="wrapper">

    <div class="card">

        <div class="logo-inside">
            <img src="{{ asset('img/logo-beltim.png') }}" alt="Logo Beltim">
        </div>

        <h1>Form Permohonan Layanan TTE</h1>
        
            <div class="form-privacy-note">
                Seluruh informasi yang dikumpulkan akan dijaga kerahasiaannya dan digunakan hanya untuk keperluan administrasi yang sah.
            </div>


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
                    <label>NIP</label>
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
                    <label>Kategori Unit</label>
                    <select id="kategoriSelect" class="form-control">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="pemerintahan">Pemerintahan</option>
                        <option value="sekolah">Sekolah</option>
                        <option value="desa">Desa</option>
                    </select>
                </div>

                <div class="form-group full-width">
                    <label>Unit Kerja</label>
                    <select name="unit_kerja" id="unitKerjaSelect" class="form-control" required>
                        <option value="">-- Pilih Unit Kerja --</option>
                        @foreach($unitKerjas as $unit)
                            <option 
                                value="{{ $unit->nama }}"
                                data-kategori="{{ $unit->kategori }}">
                                {{ $unit->nama }}
                            </option>
                        @endforeach
                    </select>
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
                Kirim Permohonan
            </button>

            <div class="form-disclaimer">
                <p>
                    Dengan mengisi dan menandatangani formulir ini, Anda menyatakan bahwa data yang diberikan adalah benar, lengkap, dan dapat dipertanggungjawabkan, serta menyetujui penggunaan tanda tangan elektronik sesuai dengan ketentuan peraturan perundang-undangan yang berlaku.
                </p>
            </div>

        </form>

    </div>

</div>

<div class="footer">
    © {{ date('Y') }} Pemerintah Kabupaten Belitung Timur
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {

    let allOptions = $('#unitKerjaSelect option').clone();

    $('#unitKerjaSelect').select2({
        placeholder: "Cari Unit Kerja",
        width: '100%'
    });

    $('#kategoriSelect').on('change', function() {

        let kategori = $(this).val();

        $('#unitKerjaSelect').empty();

        $('#unitKerjaSelect').append('<option value="">-- Pilih Unit Kerja --</option>');

        allOptions.each(function() {
            let optKategori = $(this).data('kategori');

            if (optKategori == kategori) {
                $('#unitKerjaSelect').append($(this).clone());
            }
        });

        $('#unitKerjaSelect').val('').trigger('change');
    });

});
</script>
</body>
</html>
