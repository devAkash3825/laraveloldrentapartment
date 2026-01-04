@php
$settings = DB::table('settings')->pluck('value', 'key');
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    @include('user.layout.head')
@php
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
@endphp
    <style>
            :root {
                --colorPrimary: {{ $siteColor }};
                --colorPrimaryRgb: {{ hexToRgb($siteColor) }};
                --btnColor: {{ $settings['site_btn_color'] ?? '#000000' }};
            }

            /* Global Premium Button Styles */
            .read_btn, .main-btn, .btn-primary-custom, .send-btn {
                background: var(--colorPrimary) !important;
                background: linear-gradient(135deg, var(--colorPrimary) 0%, rgba(var(--colorPrimaryRgb), 0.85) 100%) !important;
                color: white !important;
                padding: 10px 24px !important;
                border-radius: 12px !important;
                font-weight: 700 !important;
                font-size: 0.92rem !important;
                transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                gap: 10px !important;
                border: none !important;
                box-shadow: 0 4px 15px rgba(var(--colorPrimaryRgb), 0.25) !important;
                text-decoration: none !important;
                cursor: pointer;
            }

            .read_btn:hover, .main-btn:hover, .btn-primary-custom:hover, .send-btn:hover {
                transform: translateY(-3px) scale(1.02) !important;
                box-shadow: 0 10px 30px rgba(var(--colorPrimaryRgb), 0.4) !important;
                filter: brightness(1.1) !important;
            }

            .read_btn:active, .main-btn:active, .btn-primary-custom:active, .send-btn:active {
                transform: translateY(-1px) !important;
            }

            /* Smaller versions if needed */
            .btn-sm-premium {
                padding: 6px 16px !important;
                font-size: 0.82rem !important;
                border-radius: 8px !important;
            }

            /* Tooltip Fix */
            .tooltip {
                z-index: 10000 !important;
            }

            /* Global Breadcrumb / Premium Header Styling */
            .header-premium-gradient {
                background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url("{{ asset('img/breadcroumb_bg.jpg') }}");
                background-size: cover;
                background-position: center;
                background-attachment: fixed;
                position: relative;
                padding: 60px 0;
            }

            .search-btn:hover {
                filter: brightness(1.1) saturate(1.1);
                box-shadow: 0 6px 15px rgba(var(--colorPrimaryRgb), 0.35);
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
        toastr.success("{{ session('success') }}");
    @endif

    @if(session('error'))
        toastr.error("{{ session('error') }}");
    @endif

    @if(session('warning'))
        toastr.warning("{{ session('warning') }}");
    @endif

    @if(session('info'))
        toastr.info("{{ session('info') }}");
    @endif
</script>
</body>

</html>