@php
$settings = DB::table('settings')->pluck('value', 'key');
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    @include('user.layout.head')
    <style>
            :root {
                --colorPrimary: {{ $settings['site_default_color'] ?? '#000000' }};
                --btnColor: {{ $settings['site_btn_color'] ?? '#000000' }};
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