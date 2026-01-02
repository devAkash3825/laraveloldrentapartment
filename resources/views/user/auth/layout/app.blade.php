@php
$settings = DB::table('settings')->pluck('value', 'key');
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    @include('user.auth.layout.authhead')
    @stack('styles')
    <style>
            :root {
                --colorPrimary: {{ $settings['site_default_color'] ?? '#000000' }};
                --btnColor: {{ $settings['site_btn_color'] ?? '#000000' }};
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
