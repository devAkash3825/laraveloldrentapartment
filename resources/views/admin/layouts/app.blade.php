<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.layouts.head')
    @stack('style')
</head>

<body>
    <x-toast />
    @include('admin.layouts.navbar')
    @yield('content')
@include('admin.layouts.footer')
    @include('admin.layouts.scripts')
    @vite(['resources/js/app.js'])
    @stack('adminscripts')
</body>

</html>
