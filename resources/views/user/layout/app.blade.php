<!DOCTYPE html>
<html lang="en">

<head>
    @include('user.layout.head')
    @include('partials.theme_styles')
    <link rel="stylesheet" href="{{ asset('common/css/common-style.css') }}">
    <style>
        /* Specific Layout Overrides */
        .premium-sidebar {
            background: #fff;
            border-radius: 4px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            border: 1px solid #f0f0f0;
        }
        
        .profile-img-main {
            width: 120px !important;
            height: 120px !important;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin: 0 auto;
            display: block;
        }
        .profile-name {
            font-weight: 800;
            color: #1a1a1a;
            margin-bottom: 5px;
        }
        .bg-primary-gradient {
            background: var(--colorPrimary) !important;
            border: none;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            color: white;
        }
        .bg-info-gradient {
            background: #0ea5e9 !important;
            border: none;
            color: white;
        }
        .dashboard_link li a {
            border-radius: 4px;
            padding: 12px 20px !important;
            transition: all 0.3s ease;
            margin-bottom: 5px;
            color: #555 !important;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .dashboard_link li a i {
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }
        .dashboard_link li a:hover, .dashboard_link li a.active {
            background: rgba(var(--colorPrimaryRgb), 0.1);
            color: var(--colorPrimary) !important;
        }
        .dashboard_link li a.active {
            background: var(--colorPrimary);
            color: #fff !important;
            box-shadow: 0 4px 12px rgba(var(--colorPrimaryRgb), 0.3);
        }

        /* Breadcrumb / Premium Header Styling */
        .header-premium-gradient {
            background: linear-gradient(135deg, rgba(var(--colorPrimaryRgb), 0.9), rgba(var(--gradientColorRgb), 0.8)), url("{{ asset('img/breadcroumb_bg.jpg') }}") !important;
            background-size: cover !important;
            background-position: center !important;
            padding: 80px 0 !important;
            border-radius: 0;
        }
        #breadcrumb_part {
            border-radius: 0;
            overflow: hidden;
        }
        .bread_overlay {
            background: linear-gradient(135deg, rgba(var(--colorPrimaryRgb), 0.85), rgba(var(--gradientColorRgb), 0.7)) !important;
            padding: 60px 0;
        }

        /* Dashboard Content Area Premium Look */
        .dashboard_content {
            padding: 0 !important;
        }
        .my_listing {
            background: #fff;
            border-radius: 4px;
            padding: 35px !important;
            box-shadow: 0 10px 40px rgba(0,0,0,0.04);
            border: 1px solid #f2f2f2;
        }
        .my_listing h4 {
            font-weight: 800;
            color: #1a1a1a;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--colorPrimary);
            display: inline-block;
        }
        .my_listing_single label {
            font-weight: 700;
            color: #444;
            margin-bottom: 10px;
            font-size: 0.9rem;
        }
        .my_listing_single .input_area input, 
        .my_listing_single .input_area textarea,
        .my_listing_single .input_area select {
            border-radius: 4px !important;
            border: 1px solid #e0e0e0 !important;
            padding: 12px 18px !important;
            transition: all 0.3s ease;
            background: #fcfcfc;
        }
        .my_listing_single .input_area input:focus {
            border-color: var(--colorPrimary) !important;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(var(--colorPrimaryRgb), 0.1);
        }
        .profile_pic_upload img {
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
    </style>
    @stack('style')
</head>

<body>
    <div id="global-loader">
        <div class="spinner-premium"></div>
    </div>
    <div>
        @include('sweetalert::alert')
        @include('user.layout.navbar')
        <main id="main">
            @yield('content')
        </main>
        @include('user.layout.footer')
        @include('user.layout.scripts')
        @vite(['resources/js/app.js'])
        @stack('scripts')
    </div>
    @include('partials.flash_messages')
</body>

</html>