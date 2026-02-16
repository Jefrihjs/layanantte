<x-guest-layout>

<div class="login-wrapper">
    <div class="login-card">

        <div class="login-header">

            <img src="{{ asset('img/logo-tte.png') }}"
                 alt="Logo TTE"
                 class="login-logo">

            <h1>Verifikator TTE</h1>
            <p><div class="login-divider"></div>Sistem Layanan Tanda Tangan Elektronik</p>
        </div>

        <x-auth-session-status class="status-message" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label>Email</label>
                <input type="email"
                       name="email"
                       value="{{ old('email') }}"
                       required
                       autofocus
                       class="form-input">
                <x-input-error :messages="$errors->get('email')" class="error-text" />
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password"
                       name="password"
                       required
                       class="form-input">
                <x-input-error :messages="$errors->get('password')" class="error-text" />
            </div>

            <div class="remember-row">
                <label>
                    <input type="checkbox" name="remember">
                    Remember me
                </label>
            </div>

            <button type="submit" class="btn-login">
                Masuk
            </button>

        </form>

    </div>
</div>

</x-guest-layout>
