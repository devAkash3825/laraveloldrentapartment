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
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    @include('user.auth.layout.authhead')
    @stack('styles')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
            :root {
                --colorPrimary: {{ $settings['site_default_color'] ?? '#6366f1' }};
                --btnColor: {{ $settings['site_btn_color'] ?? '#4f46e5' }};
                --colorPrimaryRgb: {{ hexToRgb($settings['site_default_color'] ?? '#6366f1') }};
                --textMain: #334155;
                --textMuted: #64748b;
                --bgLight: #f8fafc;
            }
            body, html {
                margin: 0;
                padding: 0;
                height: 100%;
                width: 100%;
                overflow-x: hidden;
                font-family: 'Inter', system-ui, -apple-system, sans-serif;
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
