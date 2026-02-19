<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Layanan Permohonan TTE</title>
    <link rel="stylesheet" href="{{ asset('css/public.css') }}">
</head>
<body>

<div class="top-bar"></div>

<div class="wrapper">

    <div class="card">

        <div class="logo-inside">
            <img src="{{ asset('img/logo-beltim.png') }}" alt="Logo Beltim">
        </div>

        <h1>Layanan Permohonan TTE</h1>
        <p>Silakan masukkan NIK untuk melanjutkan permohonan</p>

        {{-- ✅ ALERT SUKSES --}}
        @if(session()->has('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('tte.check') }}">
            @csrf

            <div class="form-group">
                <label>Nomor Induk Kependudukan (NIK)</label>
                <input type="text"
                       name="nik"
                       maxlength="16"
                       placeholder="Masukkan 16 digit NIK"
                       class="form-control @error('nik') input-error @enderror"
                       value="{{ old('nik') }}"
                       required>

                @error('nik')
                    <div class="error-message">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn">
                Lanjutkan
            </button>

        </form>

    </div>

</div>

<div class="footer">
    © {{ date('Y') }} Pemerintah Kabupaten Belitung Timur
</div>

</body>
</html>
