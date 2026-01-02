<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.auth.head')
</head>
<body>
    @yield('content')
    @include('admin.auth.footer')
    @stack('authscripts')
</body>
</html>