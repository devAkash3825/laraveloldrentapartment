<!DOCTYPE html>
<html lang="en">

<head>
    @include('user.auth.layout.authhead')
    @include('partials.theme_styles')
    @stack('styles')
    
    <link rel="stylesheet" href="{{ asset('common/css/common-style.css') }}">
    <style>
            body, html {
                margin: 0;
                padding: 0;
                height: 100%;
                width: 100%;
                overflow-x: hidden;
                /* Font family handled by common-style.css */
                color: var(--textMain);
                font-size: 16px;
                line-height: 1.6;
                -webkit-font-smoothing: antialiased;
            }
            h1, h2, h3, h4, h5, h6 {
                color: #0f172a;
                font-weight: 800;
                letter-spacing: -0.025em;
            }
            label {
                color: #334155;
                font-weight: 600;
                margin-bottom: 0.5rem;
                display: block;
            }
            .text-muted {
                color: #64748b !important;
            }
            .form-side {
                overflow-y: auto !important;
                -webkit-overflow-scrolling: touch;
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
                padding: 5px;
                display: inline-flex;
                transition: color 0.2s;
                line-height: 1;
            }
            .toggle-password-btn:hover {
                color: var(--colorPrimary);
            }
            .toggle-password-btn i {
                font-size: 1.25rem;
            }
            .row {
                --bs-gutter-x: 1rem;
            }
            .mb-4 {
                margin-bottom: 1rem !important;
            }
    </style>
</head>

<body>
    <div class="overlay"></div>
    {{-- <div id="preloader" class="preloader"></div> --}}
    @yield('authcontent')
    @include('user.auth.layout.authscripts')
    @stack('authscript')
</body>

</html>
