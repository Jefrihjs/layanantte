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

            <div class="password-wrapper">
                <input type="password"
                    name="password"
                    id="password"
                    required
                    class="form-input">

                <span class="toggle-password" onclick="togglePassword()">
                    <!-- Eye Icon -->
                    <svg id="eyeIcon"
                        xmlns="http://www.w3.org/2000/svg"
                        width="20"
                        height="20"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </span>
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

<script>
function togglePassword() {
    const input = document.getElementById("password");
    const icon = document.getElementById("eyeIcon");

    if (input.type === "password") {
        input.type = "text";
        icon.innerHTML = `
            <path d="M17.94 17.94A10.94 10.94 0 0112 20C5 20 1 12 1 12a21.77 21.77 0 015.06-6.94"/>
            <path d="M1 1l22 22"/>
        `;
    } else {
        input.type = "password";
        icon.innerHTML = `
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"/>
            <circle cx="12" cy="12" r="3"/>
        `;
    }
}
</script>

</x-guest-layout>
