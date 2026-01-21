@extends('user.auth.layout.app')
@section('authcontent')
<section id="login-section" class="login-viewport">
    <div class="row g-0 h-100 w-100">
        <div class="col-lg-5 d-none d-lg-block p-0">
            <div class="hero-side h-100">
                <div class="hero-content">
                    <a href="{{ route('show-login') }}" class="back-link mb-5 d-inline-block">
                        <i class="bi bi-arrow-left"></i> Back to Login
                    </a>
                    <div class="brand">
                        <img src="{{ asset('img/logovitalg.png') }}" alt="Logo" class="img-fluid mb-4 px-4" style="max-width: 350px; filter: brightness(0) invert(1);">
                        <h1 class="display-3 fw-bold mb-4">Set Your New<br>Password</h1>
                        <p class="lead opacity-90">Secure your account with a strong password. You're just one step away from getting back in.</p>
                    </div>
                </div>
                <div class="hero-footer mt-auto">
                    <p class="mb-0 opacity-50">&copy; {{ date('Y') }} RentApartments Inc. All rights reserved.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="form-side h-100 d-flex flex-column align-items-center">
                <div class="form-container w-100 px-4 px-md-5 py-5 my-auto" style="max-width: 550px;">
                    <div class="d-lg-none mb-4 text-center">
                        <img src="{{ asset('img/logovitalg.png') }}" alt="Logo" class="img-fluid" style="max-width: 150px;">
                    </div>
                    
                    <h2 class="auth-title mb-2">Create New Password</h2>
                    <p class="auth-subtitle mb-4">Please enter your new password below.</p>

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show border-0 rounded-4 mb-4 shadow-sm" role="alert" style="background-color: #fef2f2; color: #991b1b;">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('password.update') }}" class="login-form needs-validation" method="post" novalidate>
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="email" value="{{ $email }}">

                        <div class="mb-4">
                            <label class="form-label fw-semibold">New Password</label>
                            <div class="input-group-custom">
                                <i class="bi bi-lock"></i>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="new_password" placeholder="••••••••" required>
                                <button type="button" class="toggle-password-btn" onclick="togglePasswordVisibility('new_password', event)">
                                    <i class="bi bi-eye"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Confirm New Password</label>
                            <div class="input-group-custom">
                                <i class="bi bi-lock-check"></i>
                                <input type="password" class="form-control" name="password_confirmation" id="confirm_password" placeholder="••••••••" required>
                                <button type="button" class="toggle-password-btn" onclick="togglePasswordVisibility('confirm_password', event)">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-5 pt-2">
                            <button type="submit" class="btn btn-primary-custom w-100 p-3 shadow-sm rounded-4">
                                <i class="bi bi-shield-check me-2"></i> Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .login-viewport {
        height: 100vh;
        width: 100vw;
        overflow: hidden;
        background: #fff;
    }

    .hero-side {
        background: linear-gradient(135deg, var(--colorPrimary) 0%, #111827 100%);
        padding: 80px 60px;
        display: flex;
        flex-direction: column;
        color: white;
        position: relative;
    }

    .hero-side::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background: url("{{ asset('img/login-bg.jpg') }}") no-repeat center center;
        background-size: cover;
        opacity: 0.2;
        z-index: 0;
    }

    .hero-content {
        position: relative;
        z-index: 1;
    }

    .hero-footer {
        position: relative;
        z-index: 1;
    }

    .back-link {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s;
    }

    .back-link:hover {
        color: white;
        transform: translateX(-5px);
    }

    .auth-title {
        color: #334155;
        font-weight: 800;
        letter-spacing: -1.5px;
    }

    .auth-subtitle {
        color: #64748b;
        font-size: 1.1rem;
    }

    .form-side {
        background: #ffffff;
        overflow-y: auto;
    }

    .input-group-custom {
        position: relative;
        display: flex;
        align-items: center;
        width: 100%;
    }

    .input-group-custom i:first-child {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 1.25rem;
        z-index: 5;
    }

    .input-group-custom .form-control {
        padding-left: 56px !important;
        padding-right: 50px !important;
        height: 60px;
        border-radius: 16px;
        border: 1.5px solid #e2e8f0;
        background: #f8fafc;
        color: #334155;
        font-weight: 500;
        transition: all 0.2s ease;
        width: 100%;
        font-size: 1rem;
    }

    .input-group-custom .form-control:focus {
        background: #fff;
        border-color: var(--colorPrimary);
        box-shadow: 0 0 0 4px rgba(var(--colorPrimaryRgb), 0.1);
        outline: none;
    }



    .toggle-password-btn {
        position: absolute;
        right: 18px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #94a3b8;
        cursor: pointer;
        z-index: 10;
        padding: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: color 0.2s;
    }

    .toggle-password-btn:hover {
        color: var(--colorPrimary);
    }

    @media (max-width: 991px) {
        .login-viewport {
            height: auto;
            min-height: 100vh;
            overflow-y: auto;
        }
        .form-side {
            padding: 40px 0;
        }
    }
</style>

<script>
    function togglePasswordVisibility(id, event) {
        if (event) event.preventDefault();
        const input = document.getElementById(id);
        const btn = event ? event.currentTarget : window.event.srcElement;
        const icon = btn.querySelector('i');
        
        if (input && icon) {
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        }
    }
</script>
@endsection
