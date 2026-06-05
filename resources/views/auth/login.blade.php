@extends('layouts.app')

@section('hide_navbar')@endsection

@section('content')
<style>
    *, *::before, *::after {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        background: radial-gradient(ellipse at 70% 20%, #1e3a5f 0%, #0f172a 50%, #0a0f1e 100%);
        min-height: 100vh;
        font-family: 'Nunito', sans-serif;
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        position: relative;
    }

    /* Ambient glow blobs */
    body::before {
        content: '';
        position: fixed;
        top: -200px;
        right: -100px;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(249, 115, 22, 0.12) 0%, transparent 70%);
        pointer-events: none;
        z-index: 0;
    }

    body::after {
        content: '';
        position: fixed;
        bottom: -200px;
        left: -100px;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(59, 130, 246, 0.1) 0%, transparent 70%);
        pointer-events: none;
        z-index: 0;
    }

    .login-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        min-height: 100vh;
        padding: 20px;
        position: relative;
        z-index: 1;
    }

    .login-card {
        background: rgba(255, 255, 255, 0.06);
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 28px;
        box-shadow:
            0 32px 64px rgba(0, 0, 0, 0.5),
            0 0 0 1px rgba(255, 255, 255, 0.05) inset,
            0 1px 0 rgba(255, 255, 255, 0.15) inset;
        width: 100%;
        max-width: 420px;
        overflow: hidden;
        animation: fadeInUp 0.7s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(40px) scale(0.97); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* ---- HEADER ---- */
    .login-header {
        padding: 40px 40px 28px;
        text-align: center;
        background: rgba(255, 255, 255, 0.03);
        border-bottom: 1px solid rgba(255, 255, 255, 0.07);
    }

    .logo-circle {
        width: 84px;
        height: 84px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(249, 115, 22, 0.2), rgba(30, 41, 59, 0.8));
        border: 2px solid rgba(249, 115, 22, 0.4);
        box-shadow:
            0 0 0 6px rgba(249, 115, 22, 0.07),
            0 8px 24px rgba(0, 0, 0, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 18px;
        overflow: hidden;
        transition: transform 0.4s ease, box-shadow 0.4s ease;
    }

    .logo-circle:hover {
        transform: scale(1.06) rotate(3deg);
        box-shadow:
            0 0 0 10px rgba(249, 115, 22, 0.1),
            0 12px 32px rgba(249, 115, 22, 0.25);
    }

    .logo-circle img {
        width: 56px;
        height: 56px;
        object-fit: contain;
    }

    .login-header h2 {
        font-size: 1.5rem;
        font-weight: 800;
        color: #ffffff;
        letter-spacing: -0.3px;
        margin-bottom: 6px;
        text-shadow: 0 2px 8px rgba(0,0,0,0.3);
    }

    .login-header p {
        font-size: 0.875rem;
        color: rgba(255, 255, 255, 0.48);
        font-weight: 500;
        letter-spacing: 0.3px;
    }

    /* ---- BODY ---- */
    .login-body {
        padding: 32px 40px 36px;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .input-wrapper {
        position: relative;
        width: 100%;
    }

    .form-control {
        width: 100%;
        padding: 14px 18px;
        font-size: 0.925rem;
        font-family: 'Nunito', sans-serif;
        background: rgba(255, 255, 255, 0.07);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 14px;
        color: #ffffff;
        outline: none;
        transition: border-color 0.25s, background 0.25s, box-shadow 0.25s;
        -webkit-appearance: none;
        appearance: none;
    }

    .form-control::placeholder {
        color: rgba(255, 255, 255, 0.35);
        font-size: 0.9rem;
    }

    .form-control:focus {
        border-color: rgba(249, 115, 22, 0.6);
        background: rgba(255, 255, 255, 0.1);
        box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.1);
    }

    .form-control.has-icon {
        padding-right: 48px;
    }

    .toggle-password {
        position: absolute;
        top: 50%;
        right: 14px;
        transform: translateY(-50%);
        cursor: pointer;
        color: rgba(255, 255, 255, 0.35);
        font-size: 0.9rem;
        transition: color 0.2s;
        z-index: 2;
        display: flex;
        align-items: center;
        justify-content: center;
        background: none;
        border: none;
        outline: none;
        padding: 0;
        width: 24px;
        height: 24px;
    }

    .toggle-password:hover {
        color: #f97316;
    }

    /* Remember Me */
    .remember-row {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 22px;
        margin-top: 6px;
    }

    .remember-row input[type="checkbox"] {
        width: 15px;
        height: 15px;
        accent-color: #f97316;
        cursor: pointer;
        flex-shrink: 0;
    }

    .remember-row label {
        font-size: 0.875rem;
        color: rgba(255, 255, 255, 0.55);
        cursor: pointer;
        user-select: none;
    }

    /* Login button */
    .btn-login {
        width: 100%;
        padding: 14px;
        background: linear-gradient(90deg, #f97316, #ea580c);
        border: none;
        border-radius: 14px;
        font-size: 1rem;
        font-weight: 700;
        font-family: 'Nunito', sans-serif;
        color: #ffffff;
        cursor: pointer;
        letter-spacing: 0.5px;
        box-shadow: 0 6px 20px rgba(234, 88, 12, 0.4);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-login::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 50%;
        background: rgba(255,255,255,0.1);
        border-radius: 14px 14px 0 0;
        pointer-events: none;
    }

    .btn-login:hover {
        background: linear-gradient(90deg, #fb923c, #f97316);
        box-shadow: 0 10px 28px rgba(249, 115, 22, 0.55);
        transform: translateY(-2px);
    }

    .btn-login:active {
        transform: translateY(0px);
        box-shadow: 0 4px 12px rgba(249, 115, 22, 0.35);
    }

    /* Forgot password link */
    .forgot-link {
        text-align: center;
        margin-top: 20px;
    }

    .forgot-link a {
        font-size: 0.875rem;
        color: #f97316;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s;
    }

    .forgot-link a:hover {
        color: #fb923c;
        text-decoration: underline;
    }

    /* Error states */
    .invalid-feedback {
        color: #fca5a5;
        font-size: 0.8rem;
        margin-top: 6px;
        padding-left: 4px;
        display: block;
    }

    .is-invalid {
        border-color: rgba(252, 165, 165, 0.5) !important;
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1) !important;
    }
</style>

<div class="login-wrapper">
    <div class="login-card">

        {{-- Header --}}
        <div class="login-header">
            <div class="logo-circle">
                <img src="{{ asset('backend/blp_logo.png') }}" alt="Logo BLP">
            </div>
            <h2>Login BLP Property</h2>
            <p>Sales &amp; Management Portal</p>
        </div>

        {{-- Body --}}
        <div class="login-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="form-group">
                    <div class="input-wrapper">
                        <input
                            id="email"
                            type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Email Address"
                            required
                            autofocus
                            autocomplete="email"
                        >
                    </div>
                    @error('email')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <div class="input-wrapper">
                        <input
                            id="password"
                            type="password"
                            class="form-control has-icon @error('password') is-invalid @enderror"
                            name="password"
                            placeholder="Password"
                            required
                            autocomplete="current-password"
                        >
                        <button type="button" class="toggle-password" id="togglePassword" tabindex="-1">
                            <i class="fa fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                {{-- Remember Me --}}
                <div class="remember-row">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember">{{ __('Remember Me') }}</label>
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn-login">Login</button>

                {{-- Forgot Password --}}
                @if (Route::has('password.request'))
                <div class="forgot-link">
                    <a href="{{ route('password.request') }}">Forgot Password?</a>
                </div>
                @endif

            </form>
        </div>

    </div>
</div>

{{-- FontAwesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

{{-- Toggle Password --}}
<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const pw = document.getElementById('password');
        const icon = document.getElementById('eyeIcon');
        if (pw.type === 'password') {
            pw.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            pw.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
        pw.focus();
    });
</script>

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('loginError'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Login Gagal',
        text: '{{ session('loginError') }}',
        background: '#1e293b',
        color: '#fff',
        confirmButtonColor: '#f97316',
        confirmButtonText: 'Coba Lagi'
    });
</script>
@endif
@endsection
