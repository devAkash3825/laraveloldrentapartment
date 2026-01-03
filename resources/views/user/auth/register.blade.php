@extends('user.auth.layout.app')
@section('authcontent')

<section id="register-section" class="register-viewport">
    <div class="row g-0 h-100 w-100">
        <!-- Left Side - Hero Section -->
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

        <!-- Right Side - Form Section -->
        <div class="col-lg-7">
            <div class="form-side h-100 d-flex flex-column align-items-center justify-content-center">
                <div class="form-container w-100 px-3 px-sm-4 px-md-5 py-4 py-md-5">
                    <!-- Mobile Logo -->
                    <div class="d-lg-none mb-4 text-center">
                        <img src="{{ asset('img/logovitalg.png') }}" alt="Logo" class="img-fluid" style="max-width: 150px;">
                    </div>
                    
                    <!-- Header -->
                    <div class="text-center mb-4">
                        <h2 class="auth-title mb-2">Create Account</h2>
                        <p class="auth-subtitle mb-0">Join our community and find your perfect home.</p>
                    </div>

                    <!-- Tabs -->
                    <ul class="nav nav-pills custom-tabs mb-4" id="pills-tab" role="tablist">
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link active" id="pills-renter-tab" data-bs-toggle="pill" data-bs-target="#renterregister" type="button" role="tab">
                                <i class="bi bi-person-fill me-2"></i> <span>Renter</span>
                            </button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link" id="pills-manager-tab" data-bs-toggle="pill" data-bs-target="#managerregister" type="button" role="tab">
                                <i class="bi bi-building-fill me-2"></i> <span>Manager</span>
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
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
    /* Base Viewport */
    .register-viewport {
        min-height: 100vh;
        width: 100vw;
        background: #fff;
        overflow-x: hidden;
    }

    /* Hero Side Styling */
    .hero-side {
        background: linear-gradient(135deg, var(--colorPrimary) 0%, #1a202c 100%);
        padding: 60px 50px;
        display: flex;
        flex-direction: column;
        color: white;
        position: relative;
        min-height: 100vh;
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

    .hero-content, .hero-footer {
        position: relative;
        z-index: 1;
    }

    .back-link {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s;
        font-size: 0.95rem;
    }

    .back-link:hover {
        color: white;
        transform: translateX(-5px);
    }

    /* Typography */
    .auth-title {
        color: #1e293b;
        font-weight: 800;
        letter-spacing: -0.05rem;
        font-size: clamp(1.5rem, 4vw, 2rem);
    }

    .auth-subtitle {
        color: #64748b;
        font-size: clamp(0.9rem, 2vw, 1.1rem);
    }

    /* Form Side */
    .form-side {
        background: #ffffff;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #e5e7eb transparent;
        min-height: 100vh;
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

    .form-container {
        max-width: 650px;
        width: 100%;
        margin: 0 auto;
    }

    /* Custom Tabs */
    .custom-tabs {
        background: #f1f5f9;
        padding: 6px;
        border-radius: 14px;
        display: flex;
        gap: 6px;
    }

    .custom-tabs .nav-link {
        border-radius: 10px;
        color: #64748b;
        font-weight: 600;
        padding: 12px 20px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        text-align: center;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        justify-content: center;
        white-space: nowrap;
    }

    .custom-tabs .nav-link i {
        font-size: 1.1rem;
    }

    .custom-tabs .nav-link.active {
        background: white;
        color: var(--colorPrimary);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .custom-tabs .nav-link:hover:not(.active) {
        background: rgba(255, 255, 255, 0.5);
    }

    /* Input Styling */
    .input-group-custom {
        position: relative;
        display: flex;
        align-items: center;
        width: 100%;
    }

    .input-group-custom > i:first-child {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 1.15rem;
        z-index: 5;
        pointer-events: none;
        transition: all 0.2s ease;
    }

    .input-group-custom .form-control,
    .input-group-custom .form-select {
        padding-left: 50px !important;
        padding-right: 50px !important;
        height: 54px;
        border-radius: 12px;
        border: 1.5px solid #e2e8f0;
        background: #f8fafc;
        color: #334155;
        font-weight: 500;
        transition: all 0.2s ease;
        width: 100%;
        font-size: 0.95rem;
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

    .input-group-custom .form-control:focus + i,
    .input-group-custom .form-select:focus + i {
        color: var(--colorPrimary);
    }

    /* Validation States */
    .input-group-custom .form-control.is-invalid,
    .input-group-custom .form-select.is-invalid {
        border-color: #ef4444;
        background: #fef2f2;
    }

    .input-group-custom .form-control.is-valid,
    .input-group-custom .form-select.is-valid {
        border-color: #10b981;
        background: #f0fdf4;
    }

    /* Responsive Breakpoints */
    @media (max-width: 991px) {
        .register-viewport {
            height: auto;
            min-height: 100vh;
        }
        
        .form-side {
            padding: 30px 0;
        }
        
        .custom-tabs .nav-link span {
            display: inline;
        }
    }

    @media (max-width: 576px) {
        .form-container {
            padding-left: 1rem !important;
            padding-right: 1rem !important;
        }
        
        .custom-tabs .nav-link {
            padding: 10px 12px;
            font-size: 0.85rem;
        }
        
        .custom-tabs .nav-link i {
            margin-right: 4px !important;
            font-size: 1rem;
        }
        
        .auth-title {
            font-size: 1.5rem;
        }
        
        .auth-subtitle {
            font-size: 0.9rem;
        }
        
        .input-group-custom .form-control,
        .input-group-custom .form-select {
            height: 50px;
            font-size: 0.9rem;
        }
    }

    @media (max-width: 400px) {
        .custom-tabs .nav-link span {
            display: none;
        }
        
        .custom-tabs .nav-link {
            padding: 10px;
        }
        
        .custom-tabs .nav-link i {
            margin-right: 0 !important;
            font-size: 1.2rem;
        }
    }
</style>
@endsection
