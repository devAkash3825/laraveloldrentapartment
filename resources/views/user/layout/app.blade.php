@php
$settings = DB::table('settings')->pluck('value', 'key');
if (!function_exists('hexToRgb')) {
    function hexToRgb($hex) {
        $hex = str_replace("#", "", $hex);
        if(strlen($hex) == 3) {
            $r = hexdec(substr($hex,0,1).substr($hex,0,1));
            $g = hexdec(substr($hex,1,1).substr($hex,1,1));
            $b = hexdec(substr($hex,2,1).substr($hex,2,1));
        } else {
            $r = hexdec(substr($hex,0,2));
            $g = hexdec(substr($hex,2,2));
            $b = hexdec(substr($hex,4,2));
        }
        return "$r, $g, $b";
    }
}
$siteColor = $settings['site_default_color'] ?? '#0D7C66';
$btnColor = $settings['site_btn_color'] ?? '#0D7C66';
$gradientColor = $settings['site_gradient_color'] ?? '#398E91';
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    @include('user.layout.head')
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600;700;800;900&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif !important;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Jost', sans-serif !important;
        }
    </style>
    <style>
            :root {
                --colorPrimary: {{ $siteColor }};
                --colorPrimaryRgb: {{ hexToRgb($siteColor) }};
                --btnColor: {{ $btnColor }};
                --btnColorRgb: {{ hexToRgb($btnColor) }};
                --gradientColor: {{ $gradientColor }};
                --gradientColorRgb: {{ hexToRgb($gradientColor) }};
            }

            /* Global Premium Button Styles */
            .read_btn, .main-btn, .btn-primary-custom, .send-btn, .common_btn, .grad-btn {
                background: var(--btnColor) !important;
                background: linear-gradient(135deg, var(--btnColor) 0%, var(--gradientColor) 100%) !important;
                color: white !important;
                padding: 12px 28px !important;
                border-radius: 4px !important;
                font-weight: 700 !important;
                font-size: 0.95rem !important;
                transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                gap: 10px !important;
                border: none !important;
                box-shadow: 0 4px 15px rgba(var(--btnColorRgb), 0.3) !important;
                text-decoration: none !important;
                cursor: pointer;
                border: 2px solid transparent !important;
            }

            .read_btn:hover, .main-btn:hover, .btn-primary-custom:hover, .send-btn:hover, .common_btn:hover, .grad-btn:hover {
                transform: translateY(-3px) !important;
                box-shadow: 0 10px 25px rgba(var(--btnColorRgb), 0.5) !important;
                filter: brightness(1.1) !important;
                color: white !important;
            }

            /* Premium Sidebar Styles */
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
                background: linear-gradient(135deg, var(--colorPrimary) 0%, var(--gradientColor) 100%) !important;
                border: none;
                font-size: 0.75rem;
                letter-spacing: 0.5px;
                text-transform: uppercase;
                color: white;
            }
            .bg-info-gradient {
                background: linear-gradient(135deg, #0ea5e9 0%, #3b82f6 100%) !important;
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

            /* Toaster Premium Customization */
            #toast-container > div {
                border-radius: 4px !important;
                box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
                opacity: 1 !important;
                padding: 15px 15px 15px 50px !important;
            }
            .toast-success { background-color: #0D7C66 !important; }
            .toast-error { background-color: #E74C3C !important; }

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
<script>
    @if(session('success'))
        toastr.success("<i class='fa-solid fa-circle-check me-2'></i> {{ session('success') }}");
    @endif

    @if(session('error'))
        toastr.error("<i class='fa-solid fa-circle-exclamation me-2'></i> {{ session('error') }}");
    @endif

    @if(session('warning'))
        toastr.warning("<i class='fa-solid fa-triangle-exclamation me-2'></i> {{ session('warning') }}");
    @endif

    @if(session('info'))
        toastr.info("<i class='fa-solid fa-circle-info me-2'></i> {{ session('info') }}");
    @endif
</script>
</body>

</html>