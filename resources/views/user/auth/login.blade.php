@extends('user.auth.layout.app')
@section('authcontent')

<section id="login-section" class="login-viewport">
    <div class="row g-0 h-100 w-100">
        <div class="col-lg-5 d-none d-lg-block p-0">
            <div class="hero-side h-100">
                <div class="hero-content">
                    <a href="{{ route('home') }}" class="back-link mb-5 d-inline-block">
                        <i class="bi bi-arrow-left"></i> Back to Home
                    </a>
                    <div class="brand">
                        <img src="{{ asset('img/logovitalg.png') }}" alt="Logo" class="img-fluid mb-4 px-4" style="max-width: 350px; filter: brightness(0) invert(1);">
                        <h1 class="display-3 fw-bold mb-4">Welcome<br>Back</h1>
                        <p class="lead opacity-90">Sign in to your RentApartments account to manage your listings and find your next perfect home.</p>
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

                    <h2 class="auth-title mb-2">Welcome Back</h2>
                    <p class="auth-subtitle mb-4">Please enter your details to sign in.</p>

                    @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show border-0 rounded-4 mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <form action="{{ route('login') }}" class="login-form needs-validation" method="post" novalidate>
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Username</label>
                            <div class="input-group-custom">
                                <i class="bi bi-person"></i>
                                <input type="text" class="form-control" name="username" placeholder="Enter your username" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label fw-semibold mb-0">Password</label>
                                <a href="{{ route('forgot-password') }}" class="text-primary text-decoration-none small fw-bold">Forgot password?</a>
                            </div>
                            <div class="input-group-custom">
                                <i class="bi bi-lock"></i>
                                <input type="password" class="form-control" name="password" id="login_password" placeholder="••••••••" required>
                                <button type="button" class="toggle-password-btn" onclick="togglePasswordVisibility('login_password', event)">
                                    <span><i class="bi bi-eye" id="passeye"></i></span>
                                </button>
                            </div>
                        </div>

                        <div class="mb-4 pt-2">
                            <button type="submit" class="btn btn-primary-custom w-100 p-3 shadow-sm rounded-4">
                                <i class="bi bi-box-arrow-in-right me-2"></i> Log In
                            </button>
                        </div>

                        <div class="text-center mt-5">
                            <p class="text-muted">Don't have an account? <a href="{{ route('user-register') }}" class="text-primary fw-bold text-decoration-none underline-hover">Create Account</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    #passeye {
        left: -4px !important;
    }

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
        scrollbar-width: thin;
        scrollbar-color: #e5e7eb transparent;
    }

    .form-side::-webkit-scrollbar {
        width: 6px;
    }

    .form-side::-webkit-scrollbar-track {
        background: transparent;
    }

    .form-side::-webkit-scrollbar-thumb {
        background: #e5e7eb;
        border-radius: 10px;
    }

    .form-side::-webkit-scrollbar-thumb:hover {
        background: #d1d5db;
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
        width: 20px;
        height: 20px;
        display: grid;
        place-items: center;
        pointer-events: none;
        transition: all 0.2s ease;
    }

    .input-group-custom .form-control,
    .input-group-custom .form-select {
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

    .input-group-custom .form-control::placeholder {
        color: #94a3b8;
        font-weight: 400;
    }

    .input-group-custom .form-control:focus,
    .input-group-custom .form-select:focus {
        background: #fff;
        border-color: var(--colorPrimary);
        box-shadow: 0 0 0 4px rgba(var(--colorPrimaryRgb, 106, 100, 241), 0.1);
        outline: none;
    }




    .underline-hover:hover {
        text-decoration: underline !important;
    }

    /* Toggle Password Button */
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
        line-height: 1;
    }

    .toggle-password-btn:hover {
        color: var(--colorPrimary);
    }

    .toggle-password-btn i {
        font-size: 1.25rem;
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



@endsection