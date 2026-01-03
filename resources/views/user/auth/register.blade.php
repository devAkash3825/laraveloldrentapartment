@extends('user.auth.layout.app')
@section('authcontent')
    <style>
        .login-bg a {
            color: white;
        }

        .login-bg {
            background-image: url("{{ asset('img/login-bg.jpg') }}");
            height: 100vh;
            align-content: center;
            align-items: center;
        }
    </style>



<section id="login-section" class="login-viewport">
    <div class="row g-0 h-100 w-100">
        <div class="col-lg-5 d-none d-lg-block">
            <div class="hero-side h-100">
                <div class="hero-content">
                    <a href="{{ route('home') }}" class="back-link mb-5 d-inline-block">
                        <i class="bi bi-arrow-left"></i> Back to Home
                    </a>
                    <div class="brand">
                        <img src="{{ asset('img/logovitalg.png') }}" alt="Logo" class="img-fluid mb-4 px-4" style="max-width: 350px; filter: brightness(0) invert(1);">
                        <h1 class="display-3 fw-bold mb-4">Start Your<br>Journey</h1>
                        <p class="lead opacity-90">Find your perfect home with RentApartments. Join our professional community today and unlock premium listings.</p>
                    </div>
                </div>
                <div class="hero-footer mt-auto">
                    <p class="mb-0 opacity-50">&copy; {{ date('Y') }} RentApartments Inc. All rights reserved.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="form-side h-100 d-flex flex-column align-items-center">
                <div class="form-container w-100 px-4 px-md-5 py-5 my-auto" style="max-width: 650px;">
                    <div class="d-lg-none mb-4 text-center">
                        <img src="{{ asset('img/logovitalg.png') }}" alt="Logo" class="img-fluid" style="max-width: 150px;">
                    </div>
                    
                    <h2 class="auth-title mb-2">Create Account</h2>
                    <p class="auth-subtitle mb-4">Join our community and find your perfect home.</p>

                    <ul class="nav nav-pills custom-tabs mb-5 w-100" id="pills-tab" role="tablist">
                        <li class="nav-item flex-grow-1" role="presentation">
                            <button class="nav-link active w-100" id="pills-renter-tab" data-bs-toggle="pill" data-bs-target="#renterregister" type="button" role="tab">
                                <i class="bi bi-person-fill me-2"></i> Renter
                            </button>
                        </li>
                        <li class="nav-item flex-grow-1" role="presentation">
                            <button class="nav-link w-100" id="pills-manager-tab" data-bs-toggle="pill" data-bs-target="#managerregister" type="button" role="tab">
                                <i class="bi bi-building-fill me-2"></i> Manager
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="renterregister" role="tabpanel">
                            <x-renterregister /> 
                        </div>
                        <div class="tab-pane fade" id="managerregister" role="tabpanel">
                            <x-managerregister />
                        </div>
                    </div>
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
        background: linear-gradient(135deg, var(--colorPrimary) 0%, #1a202c 100%);
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
        opacity: 0.15;
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

    .custom-tabs {
        background: #f1f5f9;
        padding: 5px;
        border-radius: 14px;
        display: flex;
        width: 100% !important;
        margin-bottom: 2rem !important;
    }

    .custom-tabs .nav-item {
        flex: 1;
    }

    .custom-tabs .nav-link {
        border-radius: 10px;
        color: #64748b;
        font-weight: 700;
        padding: 14px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        width: 100%;
        text-align: center;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .custom-tabs .nav-link.active {
        background: white;
        color: var(--colorPrimary);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .form-side {
        overflow-y: auto;
        background: #ffffff;
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

    @media (max-width: 991px) {
        .login-viewport {
            height: auto;
            min-height: 100vh;
            overflow-y: auto;
        }
        .form-side {
            padding: 20px 0;
        }
    }
</style>
@endsection
