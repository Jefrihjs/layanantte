<x-guest-layout>

<style>
    /* CSS LANGSUNG DI SINI AGAR TIDAK HANCUR */
    :root {
        --primary-teal: #0f766e;
        --dark-teal: #115e59;
        --amber-accent: #d97706;
    }

    body {
        margin: 0;
        font-family: 'Inter', sans-serif;
        background-color: #f1f5f9;
    }

    .login-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
    }

    .login-card {
        background: white;
        width: 100%;
        max-width: 450px;
        border-radius: 30px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.8);
    }

    .login-header {
        padding: 40px 40px;
        text-align: center;
        color: white;
        position: relative;
    }

    .login-logo {
        height: 80px;
        margin-bottom: 10px;
        filter: drop-shadow(0 4px 6px rgba(0,0,0,0.2));
    }

    .login-header h1 {
        margin: 0;
        font-size: 24px;
        font-weight: 800;
        letter-spacing: -0.5px;
    }

    .login-header p {
        margin: 10px 0 0;
        opacity: 0.8;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .login-divider {
        width: 30px;
        height: 2px;
        background: rgba(255,255,255,0.3);
    }

    .login-body {
        padding: 40px;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        color: #64748b;
        margin-bottom: 8px;
        margin-left: 5px;
    }

    .form-input {
        width: 100%;
        padding: 15px 20px;
        border: 2px solid #f1f5f9;
        border-radius: 15px;
        font-size: 15px;
        transition: all 0.3s ease;
        box-sizing: border-box;
        background: #f8fafc;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--primary-teal);
        background: white;
        box-shadow: 0 0 0 4px rgba(15, 118, 110, 0.1);
    }

    .password-container {
        position: relative;
    }

    .toggle-password {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #94a3b8;
        padding: 5px;
        display: flex;
        align-items: center;
    }

    .remember-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 30px;
        font-size: 14px;
        color: #64748b;
    }

    .remember-row label {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }

    .btn-login {
        width: 100%;
        padding: 15px;
        background: linear-gradient(135deg, var(--primary-teal) 0%, var(--dark-teal) 100%);
        color: white;
        border: none;
        border-radius: 15px;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 10px 15px -3px rgba(15, 118, 110, 0.3);
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 25px -5px rgba(15, 118, 110, 0.4);
    }

    .error-text {
        color: #ef4444;
        font-size: 12px;
        margin-top: 5px;
        list-style: none;
        padding: 0;
    }
</style>

<div class="login-wrapper">
    <div class="login-card">

        <div class="login-header">
            <img src="{{ asset('img/logo-tte.png') }}" alt="Logo TTE" class="login-logo">
            <h1>VERIFIKATOR TTE</h1>
            <p><span class="login-divider"></span> Sistem Layanan Tanda Tangan Elektronik <span class="login-divider"></span></p>
        </div>

        <div class="login-body">
            <x-auth-session-status class="status-message" :status="session('status')" style="margin-bottom: 20px; color: #0f766e; font-weight: bold; text-align: center;" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label>Email Adress</label>
                    <input type="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           autofocus
                           placeholder="nama@email.com"
                           class="form-input">
                    <x-input-error :messages="$errors->get('email')" class="error-text" />
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="password-container">
                        <input type="password"
                               name="password"
                               id="password"
                               placeholder="Masukkan password"
                               required
                               class="form-input">
                        
                        <span class="toggle-password" onclick="togglePassword()">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </span>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="error-text" />
                </div>

                <div class="remember-row">
                    <label>
                        <input type="checkbox" name="remember" style="accent-color: #0f766e;">
                        Ingat saya
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" style="color: #0f766e; text-decoration: none; font-weight: 600;">Lupa Password?</a>
                    @endif
                </div>

                <button type="submit" class="btn-login">
                    MASUK KE SISTEM
                </button>

            </form>
        </div>

    </div>
</div>

<script>
function togglePassword() {
    const input = document.getElementById("password");
    const icon = document.getElementById("eyeIcon");

    if (input.type === "password") {
        input.type = "text";
        icon.innerHTML = `
            <path d="M17.94 17.94A10.94 10.94 0 0112 20C5 20 1 12 1 12a21.77 21.77 0 015.06-6.94"></path>
            <path d="M1 1l22 22"></path>
        `;
    } else {
        input.type = "password";
        icon.innerHTML = `
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"></path>
            <circle cx="12" cy="12" r="3"></circle>
        `;
    }
}
</script>

</x-guest-layout>